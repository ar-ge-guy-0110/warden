<?php
    global $databaseConn;

    function UnitTable(){
        global $databaseConn;

        $query_unitTable = $databaseConn -> prepare("SELECT * FROM birim");
        $query_unitTable -> execute();

        $unit_count = $query_unitTable -> rowCount();
        
        if($unit_count > 0){
            $unit_records = $query_unitTable -> fetchAll(PDO::FETCH_ASSOC);

            foreach($unit_records as $unit_record){
                $unit_id = $unit_record["id"];
                $unit_name = $unit_record["isim"];

                if($unit_id == 1){
                    echo "<tr>";
                        echo "<td data-label='Birim Numarası'>" . $unit_id . "</td>";
                        echo "<td data-label='Birim İsmi'>" . $unit_name . "</td>";
                        echo "<td data-label='İşlem'>#</td>";
                    echo "</tr>";
                }
                else{
                    echo "<tr>";
                        echo "<td data-label='Birim Numarası'>" . $unit_id . "</td>";
                        echo "<td data-label='Birim İsmi'>" . $unit_name . "</td>";
                        echo "<td data-label='İşlem'>" . "<a href='action_updateunit.php?id=" . $unit_id . "' class='btn btn-update'>Güncelle</a>&nbsp;<a href='action_deleteunit.php?id=" . $unit_id . "' class='btn btn-delete'>Sil</a>" . "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    function AddUnit($unitname){
        global $databaseConn;

        $unitname = Filter($unitname);

        if((isset($unitname)) and ($unitname != "")){
            $action_message = "";
            $query_control = $databaseConn -> prepare("SELECT * FROM birim WHERE isim = ?");
            $query_control -> execute([$unitname]);
            $query_control_count = $query_control -> rowCount();

            if(($query_control_count <= 0)){
                $query_add = $databaseConn -> prepare("INSERT INTO birim(isim) VALUES(?)");
                $query_add -> execute([$unitname]);
                $query_affectedRows = $query_add -> rowCount();
                
                if(($query_affectedRows > 0)){
                    $action_message = "Ekleme işlemi başarıyla gerçekleştirildi.";
                    return $action_message;
                }
                else{
                    $action_message = "Bir hata oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Birim ismi halihazırda kullanılmaktadır.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }

    function FetchUnitInfoById($id){
        global $databaseConn;

        $id = Filter($id);
        if((isset($id)) and ($id != "")){
            $query_fetchinfo = $databaseConn -> prepare("SELECT * FROM birim WHERE id = ?");
            $query_fetchinfo -> execute([$id]);
            $query_fetchinfo_count = $query_fetchinfo -> rowCount();
            if($query_fetchinfo_count == 1){
                $unit_info = $query_fetchinfo -> fetch(PDO::FETCH_ASSOC);
                return $unit_info;
            }
            else{
                return 0;
            }
        }
    }

    function UpdateUnit($unit_id, $unit_name){
        global $databaseConn;

        $unit_id = Filter($unit_id);
        $unit_name = Filter($unit_name);
        $action_message = "";

        if(((isset($unit_id)) and ($unit_id != "")) and ((isset($unit_name)) and ($unit_name != ""))){
            if($unit_id != 1){
                $query_control = $databaseConn -> prepare("SELECT * FROM birim WHERE isim = ?");
                $query_control -> execute([$unit_name]);
                $query_control_count = $query_control -> rowCount();

                if(($query_control_count <= 0)){
                    $query_update = $databaseConn -> prepare("UPDATE birim SET isim = ? WHERE id = ? LIMIT 1");
                    $query_update -> execute([$unit_name, $unit_id]);
    
                    $query_update_count = $query_update -> rowCount();
    
                    if($query_update_count > 0){
                        $action_message = "Güncelleme İşlemi Başarıyla Gerçekleştirildi.";
                        return $action_message;
                    }
                    else{
                        $action_message = "Bir Hata Oluştu...";
                        return $action_message;
                    }
                }
                else{
                    $action_message = "Birim ismi halihazırda kullanılmaktadır.";
                    return $action_message;
                }
            }
            else{
                $action_message = "Yönetici Birim Güncellenemez.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }

    function DeleteUnit($unit_id){
        global $databaseConn;

        $unit_id = Filter($unit_id);
        $action_message = "";

        if(((isset($unit_id)) and ($unit_id != ""))){
            if($unit_id != 1){
                /*
                $query_delete2 = $databaseConn -> prepare("DELETE kullanici FROM kullanici JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON birim.id = kullanici_birimi.birim_id WHERE kullanici_birimi.birim_id = ?");
                $query_delete2 -> execute([$unit_id]);

                $query_delete3 = $databaseConn -> prepare("DELETE FROM kullanici_birimi WHERE birim_id = ?");
                $query_delete3 -> execute([$unit_id]);
                */

                /*
                $query_fetching_for_deleting = $databaseConn -> prepare("SELECT * FROM nobet JOIN nobetci_nobeti ON nobet.id = nobetci_nobeti.nobet_id JOIN kullanici ON kullanici.id = nobetci_nobeti.kullanici_id JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON birim.id = kullanici_birimi.birim_id WHERE");
                $query_fetching_for_deleting -> execute();
                $query_fetching_for_deleting -> fetchAll(PDO::FETCH_ASSOC);
                $query_fetch_control = $query_fetching_for_deleting -> rowCount();
                if($query_fetch_control >= 0){
                    foreach($query_fetching_for_deleting as $fetchling){
                        $onebyone_user_id = $fetchling["kullanici_id"];
                        $onebyone_
                    }
                }
                */
                //delete all watch with this unit
                //delete all wardens watch data with this unit
                $query_serious_delete = $databaseConn -> prepare("DELETE nobet, kullanici, nobetci_nobeti, kullanici_birimi, birim FROM birim JOIN kullanici_birimi ON kullanici_birimi.birim_id = birim.id JOIN kullanici ON kullanici.id = kullanici_birimi.kullanici_id JOIN nobetci_nobeti ON nobetci_nobeti.kullanici_id = kullanici.id JOIN nobet ON nobet.id = nobetci_nobeti.nobet_id WHERE birim.id = ?");
                $query_serious_delete -> execute([$unit_id]);
                $query_affectedrowcount = $query_serious_delete -> rowCount();
                /*
                $query_delete = $databaseConn -> prepare("DELETE FROM birim WHERE id = ?");
                $query_delete -> execute([$unit_id]);
                $query_affectedrowcount = $query_delete -> rowCount();
                */

                if($query_affectedrowcount > 0){
                    $action_message = "Silme İşlemi Başarıyla Gerçekleştirildi.";
                    return $action_message;
                }
                else{
                    if($query_affectedrowcount == 0){
                        $query_delete = $databaseConn -> prepare("DELETE FROM birim WHERE id = ?");
                        $query_delete -> execute([$unit_id]);
                        $query_delete_count = $query_delete -> rowCount();

                        if($query_delete_count > 0){
                            $action_message = "Silme İşlemi Başarıyla Gerçekleştirildi.";
                            return $action_message;
                        }
                    }
                    $action_message = "Bir Hata Oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Yönetici Birim Silinemez.";
                return $action_message;
            }
        }
        else{
            $action_message = "Id alınamadı.";
            return $action_message;
        }
    }
?>