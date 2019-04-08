function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function nFormatter(num) {
     if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1).replace(/\.0$/, '') + 'G';
     }
     if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
     }
     if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
     }
     return num;
}

(function( $ ){
  $.fn.nuqtaTabbedMenu = function(options) {
	  var settings = $.extend( {
		  active : 0,
		  active_link_class : "current-menu-item",
		  active_container_class : "current-content-cantainer"
		}, options);

		this.find("li").slice(settings.active,settings.active+1).addClass(settings.active_link_class);
		var current_tab = this.find("li").slice(settings.active,settings.active+1).find("a").attr("href");
		$(current_tab).addClass(settings.active_container_class);

	  this.find("li a").click(function(e){
		  $(this).parent().parent().find("li").removeClass(settings.active_link_class);
		  $(this).parent("li").addClass(settings.active_link_class);
		  $("."+settings.divclass).removeClass(settings.active_container_class);
		  var current_tab = $(this).attr("href");
		  $(current_tab).addClass(settings.active_container_class);
	   	  e.stopPropagation(); e.preventDefault();
	  });
  };
})( jQuery );

/******************************************/
/***** html 5 confirm password validation **********/
/******************************************/
jQuery(document).ready(function($) {

	if($("#password").length > 0 && $("#cpassword").length > 0)
	{
		var password = document.getElementById("password");
		var confirm_password = document.getElementById("cpassword");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
			confirm_password.setCustomValidity('');
		  }
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
	}

});


/******************************************/
/***** html 5 confirm password validation end here **********/
/******************************************/


function contact_us_map(mapdivid, map_lat, map_lng)
{
	jQuery(document).ready(function($){
		if($("#"+mapdivid).length > 0)
		{
			var map3;
			var markers3 = [];
			var map_coor_lat3 = map_lat;
			var map_coor_lng3 = map_lng;
			var mapCenter3 = new google.maps.LatLng(map_coor_lat3, map_coor_lng3);
			var myOptions3 = {
				zoom: 15,
				center: mapCenter3,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			  }

			  map3 = new google.maps.Map(document.getElementById(mapdivid), myOptions3);

			  markers3.push(new google.maps.Marker({
				position: mapCenter3,
				map: map3,
				icon: bbblog.theme_uri+"images/address_icon.png"
			  })); // markerss.push function end here

			map3.setCenter(new google.maps.LatLng(31.423897, 74.370940));


			var contentString = '<div id="content">'+
				  '<div id="bodyContent" class="map_info_window_content">'+
				  '<p style="margin-bottom:20px">House No 87, Salman Block, Nishter Colony, Lahore, Pakistan</p>'+
				  '<p><span class="phone_icon"></span>+92 324 4874422</p>'+
				  '<p><span class="email_icon"></span>contact@bytebunch.com</p>'+
				  '</div>'+
				  '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  infowindow.open(map3,markers3[0]);


		 }
	});
} // api for single map function end here

contact_us_map("contact_us_map",31.423664,74.360317);

jQuery(document).ready(function($) {

  $("ul.tabbed_menu").nuqtaTabbedMenu({divclass: "tab_menu_content",active:0});

  $(".subscribe_form").submit(function(e){
    e.preventDefault();
	  var current_form = $(this);
    var email = $(this).find("input[type=email]").val();
		email = email.trim();
		if(validateEmail(email))
		{
			$.ajax({
					beforeSend : function(){ current_form.find(".ajax_message").hide(); current_form.find(".ajax_loader").show(); },
					type: 'POST',
				    url: bbblog.ajax_url,
					data: {
            action: 'subscribe_ajax',
			      email: email
          },
          success:function(result){
									  			current_form.find(".ajax_message").html(result);
                                    current_form.find(".ajax_message").show();
											},
					 error: function(errorThrown)
									{
									  //alert(errorThrown);
									}
				}).done(function() {

					  current_form.find(".ajax_loader").hide();
					});

		}else
      {
         current_form.find(".ajax_message").html("Please enter a valid email address.");
         current_form.find(".ajax_message").show();
      }

		return false;
	});


  /*
  // facebook share count
  if($(".facebook_share").length >= 1){
    $(".facebook_share").each(function(){
      var current_item = $(this);
      var url = encodeURI($(this).find("a").attr("data-url"));
      //url = 'http://google.com';
      url = 'https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%27'+url+'%27';
      $.getJSON(url, function (data) {
        //JSON.stringify(json)
        if(typeof data.data[0] != 'undefined' && typeof data.data[0].share_count != "undefined"){
          current_item.find(".counter").text(nFormatter(data.data[0].share_count));
        }
        //console.log(url);
      });
    });
  }

  // linkedin share count
  if($(".linkedin_share").length >= 1){
    $(".linkedin_share").each(function(){
      var current_item = $(this);
      var url = encodeURI($(this).find("a").attr("data-url"));
      //url = 'http://google.com';
      url = 'https://www.linkedin.com/countserv/count/share?url='+url+'&format=jsonp&callback=?';
      $.getJSON(url, function (data) {
        //JSON.stringify(json)
        //console.log(data);
        if(typeof data != 'undefined' && typeof data.count != 'undefined'){
          current_item.find(".counter").text(nFormatter(data.count));
        }

      });
    });
  }*/

});
