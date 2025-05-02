<?php
    global $databaseConn;

    function WardenComboBox(){
        global $databaseConn;

        $query_warden = $databaseConn -> prepare("SELECT * FROM kullanici");
        $query_warden -> execute();

        $query_warden_count = $query_warden -> rowCount();
        $query_warden_records = $query_warden -> fetchAll(PDO::FETCH_ASSOC);

        if($query_warden_count > 0){
            foreach($query_warden_records as $warden_record){
                $warden_id = $warden_record["id"];
                $warden_name = $warden_record["kullanici_adi"];

                if($warden_id != 1){
                    echo "<option value='". $warden_id . "'>" . $warden_name . "</option>";
                }
            }
        }
    }

    function WatchTable(){
        global $databaseConn;

        $query_watchTable = $databaseConn -> prepare("SELECT * FROM nobet JOIN nobetci_nobeti ON nobet.id = nobetci_nobeti.nobet_id JOIN kullanici ON kullanici.id = nobetci_nobeti.kullanici_id JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON birim.id = kullanici_birimi.birim_id");
        $query_watchTable -> execute();

        $watch_count = $query_watchTable -> rowCount();
        
        if($watch_count > 0){
            $watch_records = $query_watchTable -> fetchAll(PDO::FETCH_ASSOC);

            foreach($watch_records as $watch_record){
                $watch_id = $watch_record["nobet_id"];
                $watch_start = $watch_record["baslangic"];
                $watch_end = $watch_record["bitis"];
                $watch_warden = $watch_record["kullanici_adi"];
                $watch_warden_unit = $watch_record["isim"];

                echo "<tr>";
                    echo "<td data-label='Nöbet Numarası'>" . $watch_id . "</td>";
                    echo "<td data-label='Başlangıç Tarihi'>" . $watch_start . "</td>";
                    echo "<td data-label='Bitiş Tarihi'>" . $watch_end . "</td>";
                    echo "<td data-label='Nöbetçi'>" . $watch_warden . "</td>";
                    echo "<td data-label='Birimi'>" . $watch_warden_unit . "</td>";
                    echo "<td data-label='İşlem'>" . "<a href='action_updatewatch.php?id=" . $watch_id . "' class='btn btn-update'>Güncelle</a>&nbsp;<a href='action_deletewatch.php?id=" . $watch_id . "' class='btn btn-delete'>Sil</a>" . "</td>";
                echo "</tr>";
            }
        }
    }

    function AddWatch($watch_start, $watch_end, $watch_warden){
        global $databaseConn;

        $watch_start = Filter($watch_start);
        $watch_end = Filter($watch_end);
        $watch_warden = Filter($watch_warden);

        if((isset($watch_start)) and ($watch_start != "") and (isset($watch_end)) and ($watch_end != "") and (isset($watch_warden)) and ($watch_warden != "")){
            $action_message = "";
            $query_control = $databaseConn -> prepare("SELECT * FROM nobet JOIN nobetci_nobeti ON nobet.id = nobetci_nobeti.nobet_id WHERE ? > baslangic AND ? < bitis AND ? = kullanici_id");
            $query_control -> execute([$watch_start, $watch_start, $watch_warden]);
            $query_control_count = $query_control -> rowCount();

            if(($query_control_count <= 0)){
                $query_add = $databaseConn -> prepare("INSERT INTO nobet(baslangic, bitis) VALUES(?, ?)");
                $query_add -> execute([$watch_start, $watch_end]);
                $last_watch_id = $databaseConn -> lastInsertId();
                $query_affectedRows = $query_add -> rowCount();

                
                if(($query_affectedRows > 0)){
                    $action_message = "Ekleme işlemi başarıyla gerçekleştirildi.";

                    $query_add2 = $databaseConn -> prepare("INSERT INTO nobetci_nobeti(kullanici_id, nobet_id) VALUES(?, ?)");
                    $query_add2 -> execute([$watch_warden, $last_watch_id]);
                    $query_affectedRows = $query_add2 -> rowCount();

                    if($query_affectedRows > 0){
                        return $action_message;
                    }
                    else{
                        $action_message = "Nöbetçi Nöbeti Eklenirken Hata Oluştu...";
                        return $action_message;
                    }
                }
                else{
                    $action_message = "Bir hata oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Aynı Nöbetci Belirtilen Zamanlarda halihazırda kullanılmaktadır.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }

    function FetchWatchInfoById($id){
        global $databaseConn;

        $id = Filter($id);
        if((isset($id)) and ($id != "")){
            $query_fetchinfo = $databaseConn -> prepare("SELECT * FROM nobet JOIN nobetci_nobeti ON nobet.id = nobetci_nobeti.nobet_id JOIN kullanici ON kullanici.id = nobetci_nobeti.kullanici_id JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON birim.id = kullanici_birimi.birim_id WHERE nobet_id = ?");
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

    function WardenUpdatingComboBox($wardenid){
        global $databaseConn;

        $query_warden = $databaseConn -> prepare("SELECT * FROM kullanici WHERE id <> 1");
        $query_warden -> execute();

        $query_warden_count = $query_warden -> rowCount();
        $warden_records = $query_warden -> fetchAll(PDO::FETCH_ASSOC);

        if($query_warden_count > 0){
            foreach($warden_records as $warden_record){
                $warden_id = $warden_record["id"];
                $warden_name = $warden_record["kullanici_adi"];

                if($warden_id != 1){

                    if($warden_id == $wardenid){
                        echo "<option value='". $warden_id . "' selected>" . $warden_name . "</option>";
                    }
                    else{
                        echo "<option value='". $warden_id . "'>" . $warden_name . "</option>";
                    }
                }
            }
        }
    }

    function UpdateWatch($watch_id, $watch_start, $watch_end, $watch_warden){
        global $databaseConn;

        $watch_start = Filter($watch_start);
        $watch_end = Filter($watch_end);
        $watch_warden = Filter($watch_warden);

        if((isset($watch_start)) and ($watch_start != "") and (isset($watch_end)) and ($watch_end != "") and (isset($watch_warden)) and ($watch_warden != "")){
            $action_message = "";
            $query_control = $databaseConn -> prepare("SELECT * FROM nobet JOIN nobetci_nobeti ON nobet.id = nobetci_nobeti.nobet_id WHERE ? > baslangic AND ? < bitis AND ? = kullanici_id");
            $query_control -> execute([$watch_start, $watch_start, $watch_warden]);
            $query_control_count = $query_control -> rowCount();

            if(($query_control_count <= 0)){
                $query_update = $databaseConn -> prepare("UPDATE nobetci_nobeti, nobet JOIN nobetci_nobeti nob ON nobet.id = nob.nobet_id SET baslangic = ?, bitis = ?, nob.kullanici_id = ? WHERE nob.nobet_id = ?");
                $query_update -> execute([$watch_start, $watch_end, $watch_warden, $watch_id]);
                $query_affectedRows = $query_update -> rowCount();

                
                if(($query_affectedRows > 0)){
                    $action_message = "Güncelleme işlemi başarıyla gerçekleştirildi.";
                    return $action_message;
                }
                else{
                    $action_message = "Bir hata oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Aynı Nöbetci Belirtilen Zamanlarda halihazırda kullanılmaktadır.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }

    function DeleteWatch($watch_id){
        global $databaseConn;

        $watch_id = Filter($watch_id);
        $action_message = "";

        if(((isset($watch_id)) and ($watch_id != ""))){
            if($watch_id){
                //delete all watch with this warden
                //delete all wardens watch data
                /*

                $query_delete2 = $databaseConn -> prepare("DELETE FROM kullanici_birimi WHERE kullanici_id = ?");
                $query_delete2 -> execute([$user_id]);
                $query_affectedrowcount = $query_delete2 -> rowCount();

                $query_delete = $databaseConn -> prepare("DELETE FROM kullanici WHERE id = ?");
                $query_delete -> execute([$user_id]);
                $query_affectedrowcount = $query_delete -> rowCount();
                */
                $query_serious_delete = $databaseConn -> prepare("DELETE nobetci_nobeti, nobet FROM nobet JOIN nobetci_nobeti ON nobetci_nobeti.nobet_id = nobet.id WHERE nobet.id = ?");
                $query_serious_delete -> execute([$watch_id]);
                $query_affectedrowcount = $query_serious_delete -> rowCount();

                if($query_affectedrowcount > 0){
                    $action_message = "Silme İşlemi Başarıyla Gerçekleştirildi.";
                    return $action_message;
                }
                else{
                    $action_message = "Bir Hata Oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Silinemez.";
                return $action_message;
            }
        }
        else{
            $action_message = "Id alınamadı.";
            return $action_message;
        }
    }

    function PersonalWatchTable($id){
        global $databaseConn;

        $query_watchTable = $databaseConn -> prepare("SELECT * FROM nobet JOIN nobetci_nobeti ON nobet.id = nobetci_nobeti.nobet_id JOIN kullanici ON kullanici.id = nobetci_nobeti.kullanici_id JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON birim.id = kullanici_birimi.birim_id WHERE kullanici.id = ?");
        $query_watchTable -> execute([$id]);

        $watch_count = $query_watchTable -> rowCount();
        
        if($watch_count > 0){
            $watch_records = $query_watchTable -> fetchAll(PDO::FETCH_ASSOC);

            foreach($watch_records as $watch_record){
                $watch_id = $watch_record["nobet_id"];
                $watch_start = $watch_record["baslangic"];
                $watch_end = $watch_record["bitis"];
                $watch_warden = $watch_record["kullanici_adi"];
                $watch_warden_unit = $watch_record["isim"];

                echo "<tr>";
                    echo "<td data-label='Nöbet Numarası'>" . $watch_id . "</td>";
                    echo "<td data-label='Başlangıç Tarihi'>" . $watch_start . "</td>";
                    echo "<td data-label='Bitiş Tarihi'>" . $watch_end . "</td>";
                    echo "<td data-label='Nöbetçi'>" . $watch_warden . "</td>";
                    echo "<td data-label='Birimi'>" . $watch_warden_unit . "</td>";
                echo "</tr>";
            }
        }
    }
?>