/*
	Author	: Mell Rosandich
	Date	: 6/29/2015
	email	: mell@ourace.com
	
	
	Copyright 2015 Mell Rosandich

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

		http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.

*/
function SlickDTP()
{
	this.selected_hour = "12";
	this.selected_min = "00";
	this.selected_ampm = "AM";
	this.selected_year = "";
	this.selected_month = "";
	this.selected_day = "";
	this.mysql_full_date = "0000-00-00 00:00:00";
	this.pretty_full_date = "";
	this.current_id = "";
	this.pretty_id = "";
	this.builtHTML = 0; //did we already append the html 0|1
	
	this.buildHTML();
	this.ready();
}

SlickDTP.prototype.get_time = function(){
	var DP = new Date($( "#datepicker" ).datepicker('getDate'));
	var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
	if( this.selected_min == "0"){this.selected_min = "00";}
	if( this.selected_min == "5"){this.selected_min = "05";}
	
	var tmp_month = DP.getMonth()+1;
	if( tmp_month < 10 ){tmp_month = "0" + tmp_month;}
	
	var tmp_day = DP.getDate();
	if( tmp_day < 10 ){tmp_day = "0" + tmp_day;}
	tmp_hour = this.selected_hour*1;
	if( this.selected_ampm == "PM" && tmp_hour != "12"){
		tmp_hour = tmp_hour + 12;
	}
	if( this.selected_ampm == "AM" && tmp_hour == "12" ){
		tmp_hour = 0;
	}
	if( tmp_hour> 23){tmp_hour=0;}
	if(tmp_hour <10 ){tmp_hour = "0" + tmp_hour;}
	tmp_minute = this.selected_min;
	this.mysql_full_date = DP.getFullYear() +'-'+tmp_month+'-'+tmp_day + ' ' + tmp_hour + ":" + tmp_minute + ":00";
	
	$('#dt_selected').html( monthNames[DP.getMonth()] + " " + DP.getDate() + ", " + DP.getFullYear() + " @ " + this.selected_hour + ":" + this.selected_min + " " + this.selected_ampm);
	this.selected_year = DP.getFullYear();
	this.selected_month = tmp_month;
	this.selected_day = tmp_day;
	this.pretty_full_date = monthNames[DP.getMonth()] + " " + DP.getDate() + ", " + DP.getFullYear() + " @ " + this.selected_hour + ":" + this.selected_min + " " + this.selected_ampm;
	
	return this.selected_hour + ":" + this.selected_min + " " + this.selected_ampm;
};

SlickDTP.prototype.clock_size = function(){
	for (var i = 0; i < 12; i++) {
		var bx_center = 130;
		var rad_circle = 100;
		var posx = (Math.round((rad_circle * Math.cos(i * (2 * Math.PI / 12))))+bx_center) + 'px';
		var posy = (Math.round((rad_circle * Math.sin(i * (2 * Math.PI / 12))))+bx_center) + 'px';
		$('#ch' + i).css({top: posy, left: posx, position:'absolute'});
		$('#cm' + i).css({top: posy, left: posx, position:'absolute'});
	  }
};


SlickDTP.prototype.pickDate = function(MySQLDateId,PrettyId)
{
	$('#hour_container').show();
	$('#min_container').hide();
	this.current_id = MySQLDateId;
	this.pretty_id = PrettyId;
	if( $(this.current_id).val() != "" )
	{
		var hitParts = 0;
		var mainParts = $(this.current_id).val().split(" ");
		if(mainParts[0].indexOf("-")>0)
		{
			var dateparts = mainParts[0].split("-");
			this.selected_year = dateparts[0];
			this.selected_month = dateparts[1];
			this.selected_day = dateparts[2];
			$('#datepicker').datepicker("setDate", new Date(this.selected_year,this.selected_month-1,this.selected_day) );
			hitParts++;
		}
		if(mainParts[1].indexOf(":")>0)
		{
			var timeparts = mainParts[1].split(":");
			this.selected_hour = timeparts[0];
			this.selected_min = timeparts[1];
			this.selected_ampm = "AM";
			this.setMinCircle(this.selected_min);
			if(this.selected_hour > 12 )
			{
				this.selected_hour = this.selected_hour-12;
				this.selected_ampm = "PM";
				$('.am_slide').hide();
				$('.pm_slide').show();
				$('.am_slide_l').show();
				
			}
			this.setHourCircle(this.selected_hour);
			hitParts++;
		}
		if(hitParts==2)
		{
			this.get_time();
		}
		
	}
	$( "#date_time_container" ).dialog("open");
};

SlickDTP.prototype.dateDone = function(){
	$(this.current_id).val(this.mysql_full_date);
	if( this.pretty_id != '' ){
		$(this.pretty_id).val(this.pretty_full_date);
	}
	
	$( "#date_time_container" ).dialog("close");
};


SlickDTP.prototype.setHourCircle = function(inHour)
{
	var chid = inHour -3;
	if(chid < 0 ){ chid = 12 + chid;}
	$('.circle_hour').removeClass('circle_hour_selected');
	$('#ch' + chid).addClass('circle_hour_selected');
};

SlickDTP.prototype.setMinCircle = function(inMin)
{
	inMin=inMin*1;
	if( inMin != 0 ){inMin = inMin/5;}
	var chid = inMin -3;
	if(chid < 0 ){ chid = 12 + chid;}
	$('.circle_min').removeClass('circle_min_selected');
	$('#cm' + chid).addClass('circle_min_selected');
};



SlickDTP.prototype.buildHTML = function()
{
	if(this.builtHTML == 0 ){
		$('body').append('<div id="date_time_container" title="Please select a date and time"><div id="timepicker_container"><div id="hour_container"><div class="circle_hour" id="ch9" style="top:0px;left: 130px;">12</div><div class="circle_hour" id="ch10" style="top:16px;left:196px;">1</div><div class="circle_hour" id="ch11" style="top:63px;left:244px;">2</div><div class="circle_hour" id="ch0" style="top:130px;left:260px;">3</div><div class="circle_hour" id="ch1" style="top:195px;left:243px;">4</div><div class="circle_hour" id="ch2" style="top:242px;left:196px;">5</div><div class="circle_hour" id="ch3" style="top:260px;left:130px;">6</div><div class="circle_hour" id="ch4" style="top:243px;left:67px;">7</div><div class="circle_hour" id="ch5" style="top:195px;left:16px;">8</div><div class="circle_hour" id="ch6" style="top:130px;left:0px;">9</div><div class="circle_hour" id="ch7" style="top:63px;left:15px;">10</div><div class="circle_hour" id="ch8" style="top:16px;left:64px;">11</div><div class="time_part"></div><div class="ampm_cont"><div class="am_slide_l"></div><div class="am_slide">AM</div><div class="pm_slide">PM</div></div><div class="time_title">Choose the Hour</div></div><div id="min_container"><div class="circle_min" id="cm9" style="top:0px;left: 130px;">0</div><div class="circle_min" id="cm10" style="top:16px;left:196px;">5</div><div class="circle_min" id="cm11" style="top:63px;left:244px;">10</div><div class="circle_min" id="cm0" style="top:130px;left:260px;">15</div><div class="circle_min" id="cm1" style="top:195px;left:243px;">20</div><div class="circle_min" id="cm2" style="top:242px;left:196px;">25</div><div class="circle_min" id="cm3" style="top:260px;left:130px;">30</div><div class="circle_min" id="cm4" style="top:243px;left:67px;">35</div><div class="circle_min" id="cm5" style="top:195px;left:16px;">40</div><div class="circle_min" id="cm6" style="top:130px;left:0px;">45</div><div class="circle_min" id="cm7" style="top:63px;left:15px;">50</div><div class="circle_min" id="cm8" style="top:16px;left:64px;">55</div><div class="time_part"></div><div class="ampm_cont"><div class="am_slide_l"></div><div class="am_slide">AM</div><div class="pm_slide">PM</div></div><div class="time_title">Choose the Minute</div></div></div><div id="datepick_container"><div id="datepicker"></div></div><div class="done_container"><div id="use_button_cont"><div id="dt_selected"></div><input id="use_button" type="button" value="use this date" /></div></div></div>');
	}
	this.builtHTML = 1;
};


SlickDTP.prototype.ready = function()
{
	var parentThis = this;
	$( "#datepicker" ).datepicker();
	
	$('.time_part').html( parentThis.get_time() );
	
	$( ".circle_hour" ).click(function() {
		parentThis.selected_hour = $( this ).html();
		$('.time_part').html(parentThis.get_time());
		$('#hour_container').hide();
		$('#min_container').show();
		parentThis.setHourCircle(parentThis.selected_hour);
	});

	$( ".circle_min" ).click(function() {
		parentThis.selected_min = $( this ).html();
		$('.time_part').html( parentThis.get_time() );
		$('#hour_container').show();
		$('#min_container').hide();
		parentThis.setMinCircle(parentThis.selected_min);
	});
	
	$(".am_slide").click(function() {
		$('.am_slide').toggle();
		$('.pm_slide').toggle();
		$('.am_slide_l').toggle( "slow", function() {});
		parentThis.selected_ampm = "PM";
		$('.time_part').html( parentThis.get_time() );
	});
	$(".pm_slide").click(function() {
		$('.am_slide').toggle();
		$('.pm_slide').toggle();
		$('.am_slide_l').toggle( "slow", function() {});
		parentThis.selected_ampm = "AM";
		$('.time_part').html( parentThis.get_time() );
	});

	$("#use_button").click(function() {
		parentThis.dateDone();
	});
	
	
	
	$('#datepicker').datepicker({
		 onSelect: function(d,i){
			  if(d !== i.lastVal){
				  $(this).change();
			  }
		 }
	});
	
	$('#datepicker').change(function(){
		parentThis.get_time();
	});
	 
	parentThis.clock_size();
	$( "#date_time_container" ).dialog({ height: 420 }, { width: 660 }, { autoOpen: false });
	 
};


