<?php if(is_popular() != 0) { ?>

<div class="popcity-wrap">

    <h4 class="widget-header">Popular Areas</h4>

    <div class="widget-body">

        <ul class="list-default">

        <?php
            $x = 0;
            foreach(is_popular() as $city) {
                $x++;
        ?>

            <li><a href="<?php echo base_url('city/'.$city->slug); ?>"><?php echo $city->name.', '.$city->state; ?></a></li>

        <?php if($x >= 8) { break; } } ?>

        </ul>

    </div>

</div>

<?php } ?>