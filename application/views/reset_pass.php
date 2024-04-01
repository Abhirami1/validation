<?php 

$token=$this->input->get('token');

$sql="SELECT token From registration WHERE token='$token'";
$result=$this->db->query($sql);
if($result->num_rows() >0){
    $row=$result->row();

    $fetch_token=$row->token;

    if($fetch_token!=$token)
    {
       
        echo "<script>alert('Token is valid');</script>";
        echo "<script>window.location.href = '" . base_url('login') . "';</script>";
        exit;

    }
 
}




?>

<div class="main">

<!-- Sign up form -->
<section class="signup">
    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Re-Set PassWord</h2>
                <form method="POST" class="register-form" id="register-form">
                    
                    <div class="form-group">
                        <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="pass" id="pass" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                    </div>
                   
                    <div class="form-group form-button">
                        <input type="submit" name="signup" id="signup" class="form-submit" value="reset"/>
                    </div>

                    <input type="hidden" id="token" value="<?php echo $token; ?>">
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                <a href="<?php echo base_url('login');?>" class="signup-image-link">I am already member</a>
            </div>
        </div>
    </div>
</section>

 </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){
// Custom method to check if the string contains a special character
$.validator.addMethod("specialChars", function(value, element) {
    return /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(value);
}, "Password must contain at least one special character.");

$('#register-form').validate({
    rules:{
       
        pass:{
            required: true,
            minlength: 6,
            specialChars: true,
            // digits: true 
        },
        re_pass:{
            required: true,
            equalTo: "#pass" // Compares the value to the #pass field
        },
    },
    messages:{
        
        pass: {
            required: 'Enter Password',
            minlength: 'Password must be at least 6 characters long',
            specialChars: 'Password must contain at least one special character',
            // digits: 'Password must contain at least one digit'
        },
        re_pass: {
            required: 'Enter re-enter password',
            equalTo: 'Passwords do not match'
        }
    },
    submitHandler: function(form) {
        if($(form).valid()) {
            
            var token=$('#token').val();

                // Add token to form data
                var formData = $(form).serializeArray();
                formData.push({name: 'token', value: token});


            $.ajax({
                type: "POST",
                url: "<?php echo base_url('reset_user');?>",
                data: formData,
                success: function(response) {

                   
                
                    if (response.status==='success') {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Reset Password successful",
                            showConfirmButton: false,
                            timer: 5000
                        });
                        
                            // Redirect to login page after the timer finishes
                            window.location.href = "<?php echo base_url('login');?>";
                         
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error", // Use "error" instead of "failed"
                            title: "Reset Failed",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.href = "<?php echo base_url('forgot_password');?>";

                        
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });


        } else {
            console.log('Form validation failed');
        }
    }
});
});
</script>

<style>
.error {
color: red;
}
</style>