<?php

$imageresult = $_POST['keyvaluearray'];
            $remFile = $imageresult[1];
            $remFileOrig = $imageresult[2];
            unlink($remFile) or die("Couldn't delete file");
            if ($remFile != $remFileOrig) {
                unlink($remFileOrig) or die("Couldn't delete file");
            }
            ?>