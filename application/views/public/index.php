<p>Show all image</p>
<p>With slider</p>
<p>And one big image box contain image, and file name</p>
<p>Site description</p>
<br/><br/>
<div class="slider center" style="background-color: black;margin:30px;">
    <div><img src="<?php echo base_url('uploads/Chrysanthemum_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Desert_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Jellyfish_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Koala_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Lighthouse_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Penguins_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Tulips_small.jpg');?>"/></div>
    <div><img src="<?php echo base_url('uploads/Hydrangeas_small.jpg');?>"/></div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/jquery-3.0.0.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/slick/slick.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.center').slick({
        centerMode: true,
        centerPadding: '10px',
        slidesToShow: 3,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });
});
</script>
