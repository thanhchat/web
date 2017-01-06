<script>
    function getProductFeature(){
		var str='';
		<?php foreach($arrayFeature['listFeatureType'] as $k=>$featureType){?>
				str+=$('#<?=$featureType['PRODUCT_FEATURE_TYPE_ID']?>').val()+'@';
			<?php }?>
		str=str.replace(/@*$/, "");	
		$.ajax({
                    type: "GET",
                    url: '/mvc/controller/ajax/product.php?idProduct='+<?=$detailP;?>+'&feature='+str,
                    dataType: "text",
                    success: function (response) {
                        $('#price').html(response);
                    }
                });
	}
</script>
