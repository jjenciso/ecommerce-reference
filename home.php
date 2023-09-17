<?php
require_once 'connection.php';

$sql = "SELECT * FROM product";
$all_product = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>eCommerce</title>
</head>
<style>
    .article-card {
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        margin-top: 30px;
        max-width: 300px;
        height: 400px;
        flex: 1 1 210px;
        border: 1px solid #ccc;

        display: flex;
        flex-direction: column;
    }

    .card .image {
        height: 60%;
        margin-bottom: 20px;
    }

    .card .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card .caption {
        display: flex;
        flex-direction: column;
        align-items: flex-start;

        padding-left: 1em;
        line-height: 23px;
        height: 25%;
    }

    .card .caption .rate {
        display: flex;
        gap: 3px;
    }

    .card .caption .rate i {
        color: gold;
    }

    del {
        text-decoration: line-through;
    }

    .card .add-button {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card .add-button .add {
        border: 1px solid #000;
        padding: 5px;
        cursor: pointer;
        margin-top: 8px;
        width: 80%;
        transition: all .5s;
    }

    .card .add-button .add:hover {
        font-weight: bold;
        background-color: rgba(0, 0, 0, 0.6);
        color: #fff;
    }
</style>

<body>
    <?php
    include_once 'header.php';
    ?>

    <section class="container">
        <?php
        while ($row = mysqli_fetch_assoc($all_product)) {
        ?>
            <article class="product-card">
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["product_image"]; ?>" alt="clothe2">
                    </div>

                    <div class="caption">
                        <p class="rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </p>
                        <p class="product_name"><?php echo $row["product_name"] ?></p>
                        <p class="price"><b><?php echo $row["price"] ?></b></p>
                        <p class="discount"><del><?php echo $row["discount"] ?></del></p>

                    </div>
                    <div class="add-button">
                        <button class="add" data-id="<?php echo $row["product_id"];?>">Add to cart</button>
                    </div>
                </div>
            </article>
        <?php
        }
        ?>
    </section>
    <script>
        let product_id = document.getElementsByClassName("add");
        for(let i = 0; i<product_id.length; i++){
            product_id[i].addEventListener("click",function(e){
                let target = e.target;
                let id = target.getAttribute("data-id");
                let xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        let data = JSON.parse(this.responseText);
                        target.innerHTML = data.in_cart;
                        document.getElementById("badge").innerHTML = data.num_cart + 1;
                    }
                }

                xml.open("GET","connection.php?id="+id,true);
                xml.send();

            })
        }
    </script>
</body>

</html>