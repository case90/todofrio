
<div id="BlockSuppliers">
	<div class="row">
		<section class="regular slider">
		{foreach from=$suppliers item=supplier name=su }

			<div class="supplierContainer displayTable">
				<a href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'htmlall':'UTF-8'}">
					<img src="{$base_dir_ssl}img/su/{$supplier.id_supplier}.jpg"/>
				</a>
			</div>
			
		{/foreach}
		</section>
	</div>
</div>


<script type="text/javascript">
    $(document).on('ready', function() {
     
      $(".regular").slick({
        dots: false,
        infinite: true,
        slidesToShow: 8,
        autoplay: true,
        slidesToScroll: 3,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });
      
    });
</script>
