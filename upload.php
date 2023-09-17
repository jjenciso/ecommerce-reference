<?php
    require_once 'connection.php';

    if(isset($_POST["submit"])){
        $productname = $_POST["productname"];
        $price = $_POST["price"];
        $discount = $_POST["discount"];

        // For upload photos
        $upload_dir = "uploads/";
        $product_image = $upload_dir.$_FILES["imageUpload"]["name"];
        $upload_dir.$_FILES["imageUpload"]["name"];
        $upload_file = $upload_dir.basename($_FILES["imageUpload"]["name"]);
        $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
        $check = $_FILES["imageUpload"]["size"];
        $upload_ok = 0;

        if(file_exists($upload_file)){
            echo "<script>alert('The file already exist')</script>";
            $upload_ok = 0;
        }else{
            $upload_ok = 1;
            if($check !== false){
                $upload_ok = 1;
                if($imageType == 'jpg' || $imageType == 'png' || $imageType == 'jpeg' || $imageType == 'webpg'){
                    $upload_ok = 1;
                }else{
                    echo "<script>alert('Invalid image format')</script>";
                }
            }else {
                echo "<script>alert('The photo size is 0 please change the photo')</script>";
                $upload_ok = 0;
            }
        }

        if($upload_ok == 0){
            echo "<script>alert('Sorry you file was not uploaded. Please try again')</script>";
        }else{
            if($productname != "" && $price != ""){
                move_uploaded_file($_FILES["imageUpload"]["tmp_name"],$upload_file);

                $sql = "INSERT INTO product(product_name,price,discount,product_image)
                        VALUES('$productname',$price,$discount,'$product_image')";
                
                if($conn->query($sql) === TRUE){
                    echo "<script>alert('Item uploaded succesfully')</script>";
                }
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php
    include_once 'header.php';
    ?>
    <section class="container upload-container" id="upload-container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="productname" id="productname" placeholder="Product Name" required>
            <input type="number" name="price" id="price" placeholder="Product Price" required>
            <input type="number" name="discount" id="discount" placeholder="Discount">
            <input type="file" name="imageUpload" id="imageUpload" required>
            <button id="choose" onclick="upload();" >Choose Image</button>
            <input type="submit" value="Upload" name="submit">
        </form>
    </section>

    <script>
        let productName = document.getElementById("productname");
        let productPrice = document.getElementById("price");
        let discount = document.getElementById("discount");
        let choose = document.getElementById("choose");
        let uploadImage = document.getElementById("imageUpload");


        function upload() {
            uploadImage.click();
        }

        uploadImage.addEventListener("change", function(){
            let file = this.files[0];
            if (productName.value == ""){
                productName.value = file.name;
            }
            choose.innerHTML = "You can change("+file.name+") picture";
        })
        
    </script>
</body>

</html>