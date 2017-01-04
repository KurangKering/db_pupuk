        <ul class="nav">
            <?php 
            foreach ($lists as $data) {
                echo "<li>
                <a href='$data[link]'>
                    <i class='$data[icon]'></i>
                    <p>$data[title]</p>
                </a>
            </li>";
        }
        ?>

    </ul>