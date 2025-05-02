<?php 
    global $databaseConn;

    function UnitComboBox(){
        global $databaseConn;

        $query_unit = $databaseConn -> prepare("SELECT * FROM birim");
        $query_unit -> execute();

        $query_unit_count = $query_unit -> rowCount();
        $query_unit_records = $query_unit -> fetchAll(PDO::FETCH_ASSOC);

        if($query_unit_count > 0){
            foreach($query_unit_records as $unit_record){
                $unit_id = $unit_record["id"];
                $unit_name = $unit_record["isim"];

                if($unit_id != 1){
                    echo "<option value='". $unit_id . "'>" . $unit_name . "</option>";
                }
            }
        }
    }

    function UserTable(){
        global $databaseConn;

        $query_userTable = $databaseConn -> prepare("SELECT * FROM kullanici JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON kullanici_birimi.birim_id = birim.id");
        $query_userTable -> execute();

        $user_count = $query_userTable -> rowCount();
        
        if($user_count > 0){
            $user_records = $query_userTable -> fetchAll(PDO::FETCH_ASSOC);

            foreach($user_records as $user_record){
                $user_id = $user_record["kullanici_id"];
                $user_name = $user_record["kullanici_adi"];
                $user_pass = $user_record["sifre"];
                $user_tcno = $user_record["tc_no"];
                $user_email = $user_record["e_posta_adresi"];
                $user_role = $user_record["rol"];
                $user_unit = $user_record["isim"];

                if($user_id == 1){
                    echo "<tr>";
                        echo "<td data-label='Kullanıcı Numarası'>" . $user_id . "</td>";
                        echo "<td data-label='Kullanıcı İsmi'>" . $user_name . "</td>";
                        echo "<td data-label='Şifre'>" . $user_pass . "</td>";
                        echo "<td data-label='TC Kimlik No'>" . $user_tcno . "</td>";
                        echo "<td data-label='E-Posta Adresi'>" . $user_email . "</td>";
                        echo "<td data-label='Rolü'>" . $user_role . "</td>";
                        echo "<td data-label='Birimi'>" . $user_unit . "</td>";
                        echo "<td data-label='İşlem'>#</td>";
                    echo "</tr>";
                }
                else{
                    echo "<tr>";
                        echo "<td data-label='Kullanıcı Numarası'>" . $user_id . "</td>";
                        echo "<td data-label='Kullanıcı İsmi'>" . $user_name . "</td>";
                        echo "<td data-label='Şifre'>" . $user_pass . "</td>";
                        echo "<td data-label='TC Kimlik No'>" . $user_tcno . "</td>";
                        echo "<td data-label='E-Posta Adresi'>" . $user_email . "</td>";
                        echo "<td data-label='Rolü'>" . $user_role . "</td>";
                        echo "<td data-label='Birimi'>" . $user_unit . "</td>";
                        echo "<td data-label='İşlem'>" . "<a href='action_updateuser.php?id=" . $user_id . "' class='btn btn-update'>Güncelle</a>&nbsp;<a href='action_deleteuser.php?id=" . $user_id . "' class='btn btn-delete'>Sil</a>" . "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    function AddUser($user_name, $user_pass, $user_tcno, $user_email, $user_unit){
        global $databaseConn;

        $user_name = Filter($user_name);
        $user_pass = Filter($user_pass);
        $user_tcno = Filter($user_tcno);
        $user_email = Filter($user_email);
        $user_unit = Filter($user_unit);

        if((isset($user_name)) and ($user_name != "") and (isset($user_pass)) and ($user_pass != "") and (isset($user_tcno)) and ($user_tcno != "") and (isset($user_email)) and ($user_email != "") and (isset($user_unit)) and ($user_unit != "")){
            $action_message = "";
            $query_control = $databaseConn -> prepare("SELECT * FROM kullanici WHERE kullanici_adi = ? OR tc_no = ? OR e_posta_adresi = ?");
            $query_control -> execute([$user_name, $user_tcno, $user_email]);
            $query_control_count = $query_control -> rowCount();

            if(($query_control_count <= 0)){
                $query_add = $databaseConn -> prepare("INSERT INTO kullanici(kullanici_adi, sifre, tc_no, e_posta_adresi, rol) VALUES(?, ?, ?, ?, ?)");
                $query_add -> execute([$user_name, $user_pass, $user_tcno, $user_email, 2]);
                $last_user_id = $databaseConn -> lastInsertId();
                $query_affectedRows = $query_add -> rowCount();

                
                if(($query_affectedRows > 0)){
                    $action_message = "Ekleme işlemi başarıyla gerçekleştirildi.";

                    $query_add2 = $databaseConn -> prepare("INSERT INTO kullanici_birimi(kullanici_id, birim_id) VALUES(?, ?)");
                    $query_add2 -> execute([$last_user_id, $user_unit]);
                    $query_affectedRows = $query_add2 -> rowCount();

                    if($query_affectedRows > 0){
                        return $action_message;
                    }
                    else{
                        $action_message = "Kullanıcı Birimi Eklenirken Hata Oluştu...";
                        return $action_message;
                    }
                }
                else{
                    $action_message = "Bir hata oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Aynı Kullanıcı İsmi veya TC Kimlik No veya E-Posta Adresi halihazırda kullanılmaktadır.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }

    function FetchUserInfoById($id){
        global $databaseConn;

        $id = Filter($id);
        if((isset($id)) and ($id != "")){
            $query_fetchinfo = $databaseConn -> prepare("SELECT * FROM kullanici JOIN kullanici_birimi ON kullanici.id = kullanici_birimi.kullanici_id JOIN birim ON kullanici_birimi.birim_id = birim.id WHERE kullanici.id = ?");
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

    function UnitUpdatingComboBox($unitid){
        global $databaseConn;

        $query_unit = $databaseConn -> prepare("SELECT * FROM birim");
        $query_unit -> execute();

        $query_unit_count = $query_unit -> rowCount();
        $query_unit_records = $query_unit -> fetchAll(PDO::FETCH_ASSOC);

        if($query_unit_count > 0){
            foreach($query_unit_records as $unit_record){
                $unit_id = $unit_record["id"];
                $unit_name = $unit_record["isim"];

                if($unit_id != 1){

                    if($unit_id == $unitid){
                        echo "<option value='". $unit_id . "' selected>" . $unit_name . "</option>";
                    }
                    else{
                        echo "<option value='". $unit_id . "'>" . $unit_name . "</option>";
                    }
                }
            }
        }
    }

    function UpdateUser($user_id, $user_name, $user_pass, $user_tcno, $user_email, $user_unit){
        global $databaseConn;

        $user_id = Filter($user_id);
        $user_name = Filter($user_name);
        $user_pass = Filter($user_pass);
        $user_tcno = Filter($user_tcno);
        $user_email = Filter($user_email);
        $user_unit = Filter($user_unit);

        if((isset($user_id)) and ($user_id != "") and (isset($user_name)) and ($user_name != "") and (isset($user_pass)) and ($user_pass != "") and (isset($user_tcno)) and ($user_tcno != "") and (isset($user_email)) and ($user_email != "") and (isset($user_unit)) and ($user_unit != "")){
            $action_message = "";
            $query_control = $databaseConn -> prepare("SELECT * FROM kullanici WHERE kullanici_adi = ? OR tc_no = ? OR e_posta_adresi = ?");
            $query_control -> execute([$user_name, $user_tcno, $user_email]);
            $query_control_count = $query_control -> rowCount();

            if(($query_control_count <= 0)){
                $query_update = $databaseConn -> prepare("UPDATE kullanici SET kullanici_adi = ?, sifre = ?, tc_no = ?, e_posta_adresi = ?, rol = ? WHERE id = ?");
                $query_update -> execute([$user_name, $user_pass, $user_tcno, $user_email, 2, $user_id]);
                $query_affectedRows = $query_update -> rowCount();

                
                if(($query_affectedRows > 0)){
                    $action_message = "Güncelleme işlemi başarıyla gerçekleştirildi.";

                    $query_update2 = $databaseConn -> prepare("UPDATE kullanici_birimi SET birim_id = ? WHERE kullanici_id = ?");
                    $query_update2 -> execute([$user_unit, $user_id]);
                    $query_affectedRows = $query_update2 -> rowCount();

                    if($query_affectedRows > 0){
                        return $action_message;
                    }
                    else{
                        $action_message = "Kullanıcı Birimi Güncellenirken Hata Oluştu...";
                        return $action_message;
                    }
                }
                else{
                    $action_message = "Bir hata oluştu...";
                    return $action_message;
                }
            }
            else{
                $action_message = "Aynı Kullanıcı İsmi veya TC Kimlik No veya E-Posta Adresi halihazırda kullanılmaktadır.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }

    function DeleteUser($user_id){
        global $databaseConn;

        $user_id = Filter($user_id);
        $action_message = "";

        if(((isset($user_id)) and ($user_id != ""))){
            if($user_id != 1){
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
                $query_serious_delete = $databaseConn -> prepare("DELETE nobet, nobetci_nobeti, kullanici_birimi, kullanici FROM kullanici JOIN nobetci_nobeti ON nobetci_nobeti.kullanici_id = kullanici.id JOIN nobet ON nobet.id = nobetci_nobeti.nobet_id JOIN kullanici_birimi ON kullanici_birimi.kullanici_id = kullanici.id WHERE kullanici.id = ?");
                $query_serious_delete -> execute([$user_id]);
                $query_affectedrowcount = $query_serious_delete -> rowCount();

                if($query_affectedrowcount > 0){
                    $action_message = "Silme İşlemi Başarıyla Gerçekleştirildi.";
                    return $action_message;
                }
                else{
                    if($query_affectedrowcount == 0){
                        $query_delete = $databaseConn -> prepare("DELETE FROM kullanici WHERE id = ?");
                        $query_delete -> execute([$user_id]);
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
                $action_message = "Yönetici Kullanıcısı Silinemez.";
                return $action_message;
            }
        }
        else{
            $action_message = "Id alınamadı.";
            return $action_message;
        }
    }

    function UpdateAdmin($name, $pass){
        global $databaseConn;
        $name = Filter($name);
        $pass = Filter($pass);

        if((isset($name)) and ($name != "") and (isset($pass)) and ($pass != "")){
            $action_message = "";
            $query_control = $databaseConn -> prepare("SELECT * FROM kullanici WHERE kullanici_adi = ?");
            $query_control -> execute([$name]);
            $query_control_count = $query_control -> rowCount();

            if(($query_control_count <= 0)){
                $query_update = $databaseConn -> prepare("UPDATE kullanici SET kullanici_adi = ?, sifre = ? WHERE id = ?");
                $query_update -> execute([$name, $pass, 1]);
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
                $action_message = "Aynı Kullanıcı İsmi halihazırda kullanılmaktadır.";
                return $action_message;
            }
        }
        else{
            $action_message = "Bütün Bilgileri Doldurduğunuza Emin Olunuz.";
            return $action_message;
        }
    }
?>