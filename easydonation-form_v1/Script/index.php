<!DOCTYPE html>
<html>
    <head>
          <?php include 'configuration.php'; ?> 
         <?php include 'includes/header.php'; ?>
         <?php include 'includes/validation_php.php'; ?>
        <title><?php echo TITLE; ?></title>   
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
    </head>
   
    
    

    <?php
    
    
    
    if($installed){
     include_once 'home.php';
    }else{
        include_once 'popup.php';
    } ?>
    
        
</body>
</html> 


