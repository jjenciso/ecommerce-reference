<?php
require_once 'connection.php';

$sql_cart = "SELECT * FROM cart";
$all_cart = $conn->query($sql_cart);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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

    <main class="container">
        <h1><?php echo mysqli_num_rows($all_cart); ?></h1>
        <hr>
        <?php
        while ($row_cart = mysqli_fetch_assoc($all_cart)) {
            $sql = "SELECT * FROM product WHERE product_id=" . $row_cart["product_id"];
            $all_product = $conn->query($sql);
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
                            <button class="remove" data-id="<?php echo $row["product_id"]; ?>">Remove from cart</button>
                        </div>
                    </div>
                </article>
        <?php
            }
        }
        ?>
    </main>

    <script>
        let remove = document.getElementsByClassName("remove");
        for(let i = 0; i<remove.length; i++){
            remove[i].addEventListener("click",function(e){
                let target = e.target;
                let cart_id = target.getAttribute("data-id");
                let xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        target.innerHTML = this.responseText;
                        target.style.opacity = .3;
                    } 
                }

                xml.open("GET","connection.php?cart_id="+cart_id,true);
                xml.send();
            })
        }
    </script>
</body>

</html>