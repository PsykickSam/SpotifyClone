<?php include("pages/index/header.php") ?>

<h1 class="pageHeadingBig">You might also like</h1>

<div class="gridViewContainer">

    <?php

        $query = $querier::get($table::$albums['table'], array(), array(), array()) . " ORDER BY RAND() LIMIT 10";
        $result = mysqli_query($db->connection(), $query);

        while ($row = mysqli_fetch_array($result)) {
            $id = $row[$table::$albums['columns']['_id']];
            $title = $row[$table::$albums['columns']['title']];
            $artwork = $row[$table::$albums['columns']['artwork_path']];

            echo 
            "
                <div class='gridViewItem'>
                    <a href='album.php?id=$id'>
                        <img src='$artwork' alt='Album Image'>
                        <div class='gridViewInfo'>$title</div>
                    </a>
                </div>

            ";
        }

    ?>

</div>

<?php include("pages/index/footer.php") ?>