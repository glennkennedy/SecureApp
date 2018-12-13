<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = $BIC = $IBAN = $PPSNo = "";
$name_err = $address_err = $salary_err = $BIC_err = $IBAN_err = $PPSNo_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Validate salary
    $input_BIC = trim($_POST["BIC"]);
    if(empty($input_BIC)){
        $salary_err = "Please enter the BIC.";     
    } elseif(!ctype_digit($input_BIC)){
        $BIC_err = "Please enter a positive integer value.";
    } else{
        $BIC = $input_BIC;
    }
    
    // Validate salary
    $input_IBAN = trim($_POST["IBAN"]);
    if(empty($input_IBAN)){
        $IBAN_err = "Please enter the IBAN code.";     
    } elseif(!ctype_digit($input_IBAN)){
        $IBAN_err = "Please enter a positive integer value.";
    } else{
        $IBAN = $input_IBAN;
    }
    
    // Validate salary
    $input_PPSNo = trim($_POST["PPSNo"]);
    if(empty($input_PPSNo)){
        $PPSNo = "Please enter the PPS number.";     
    } elseif(!ctype_digit($input_PPSNo)){
        $PPSNo_err = "Please enter a positive integer value.";
    } else{
        $PPSNo = $input_PPSNo;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($BIC_err) && empty($IBAN_err) && empty($PPSNo_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary, BIC, IBAN, PPSNo) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_address, $param_salary, $param_BIC, $param_IBAN, $param_PPSNo);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_BIC = $BIC;
            $param_IBAN = $IBAN;
            $param_PPSNo = $PPSNo;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($BIC_err)) ? 'has-error' : ''; ?>">
                            <label>BIC</label>
                            <input type="text" name="BIC" class="form-control" value="<?php echo $BIC; ?>">
                            <span class="help-block"><?php echo $BIC_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($IBAN_err)) ? 'has-error' : ''; ?>">
                            <label>IBAN</label>
                            <input type="text" name="IBAN" class="form-control" value="<?php echo $IBAN; ?>">
                            <span class="help-block"><?php echo $IBAN_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($PPSNo_err)) ? 'has-error' : ''; ?>">
                            <label>PPS No.</label>
                            <input type="text" name="PPSNo" class="form-control" value="<?php echo $PPSNo; ?>">
                            <span class="help-block"><?php echo $PPSNo_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>