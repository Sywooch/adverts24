/*
 @package    yii2-krajee-base
 @subpackage yii2-widget-activeform
 @author     Kartik Visweswaran <kartikv2@gmail.com>
 @copyright  Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 @version    1.8.9

 Common client validation file for all Krajee widgets.

 For more JQuery/Bootstrap plugins and demos visit http://plugins.krajee.com
 For more Yii related demos visit http://demos.krajee.com
*/
var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.findInternal=function(d,g,m){d instanceof String&&(d=String(d));for(var p=d.length,r=0;r<p;r++){var v=d[r];if(g.call(m,v,r,d))return{i:r,v:v}}return{i:-1,v:void 0}};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.defineProperty=$jscomp.ASSUME_ES5||"function"==typeof Object.defineProperties?Object.defineProperty:function(d,g,m){d!=Array.prototype&&d!=Object.prototype&&(d[g]=m.value)};
$jscomp.getGlobal=function(d){return"undefined"!=typeof window&&window===d?d:"undefined"!=typeof global&&null!=global?global:d};$jscomp.global=$jscomp.getGlobal(this);$jscomp.polyfill=function(d,g,m,p){if(g){m=$jscomp.global;d=d.split(".");for(p=0;p<d.length-1;p++){var r=d[p];r in m||(m[r]={});m=m[r]}d=d[d.length-1];p=m[d];g=g(p);g!=p&&null!=g&&$jscomp.defineProperty(m,d,{configurable:!0,writable:!0,value:g})}};
$jscomp.polyfill("Array.prototype.find",function(d){return d?d:function(d,m){return $jscomp.findInternal(this,d,m).v}},"es6","es3");$jscomp.polyfill("Array.prototype.fill",function(d){return d?d:function(d,m,p){var r=this.length||0;0>m&&(m=Math.max(0,r+m));if(null==p||p>r)p=r;p=Number(p);0>p&&(p=Math.max(0,r+p));for(m=Number(m||0);m<p;m++)this[m]=d;return this}},"es6","es3");
(function(d){"function"===typeof define&&define.amd?define(["jquery"],d):"object"===typeof exports?d(require("jquery")):d(jQuery)})(function(d,g){function m(){return new Date(Date.UTC.apply(Date,arguments))}"indexOf"in Array.prototype||(Array.prototype.indexOf=function(a,b){b===g&&(b=0);0>b&&(b+=this.length);0>b&&(b=0);for(var c=this.length;b<c;b++)if(b in this&&this[b]===a)return b;return-1});var p=function(a){a=(a||new Date).getTimezoneOffset();var b=Math.abs(a),c=a?Math.floor(b/60):"";b=a?b%60:
"";return(a?0<a?"GMT-":"GMT+":"GMT")+(""===c?"":10>c?"0"+c:""+c)+(""===b?"":10>b?"0"+b:""+b)},r=function(a,b){var c=this;this.element=d(a);this.container=b.container||"body";this.language=b.language||this.element.data("date-language")||"en";this.language=this.language in h?this.language:this.language.split("-")[0];this.language=this.language in h?this.language:"en";this.isRTL=h[this.language].rtl||!1;this.formatType=b.formatType||this.element.data("format-type")||"standard";this.format=f.parseFormat(b.format||
this.element.data("date-format")||h[this.language].format||f.getDefaultFormat(this.formatType,"input"),this.formatType);this.isVisible=this.isInline=!1;this.isInput=this.element.is("input");this.fontAwesome=b.fontAwesome||this.element.data("font-awesome")||!1;this.bootcssVer=b.bootcssVer||(this.isInput?this.element.is(".form-control")?3:2:this.bootcssVer=this.element.is(".input-group")?3:2);this.component=this.element.is(".date")?3==this.bootcssVer?this.element.find(".input-group-addon .glyphicon-th, .input-group-addon .glyphicon-time, .input-group-addon .glyphicon-remove, .input-group-addon .glyphicon-calendar, .input-group-addon .fa-calendar, .input-group-addon .fa-clock-o").parent():
this.element.find(".add-on .icon-th, .add-on .icon-time, .add-on .icon-calendar, .add-on .fa-calendar, .add-on .fa-clock-o").parent():!1;this.componentReset=this.element.is(".date")?3==this.bootcssVer?this.element.find(".input-group-addon .glyphicon-remove, .input-group-addon .fa-times").parent():this.element.find(".add-on .icon-remove, .add-on .fa-times").parent():!1;this.hasInput=this.component&&this.element.find("input").length;this.component&&0===this.component.length&&(this.component=!1);this.linkField=
b.linkField||this.element.data("link-field")||!1;this.linkFormat=f.parseFormat(b.linkFormat||this.element.data("link-format")||f.getDefaultFormat(this.formatType,"link"),this.formatType);this.minuteStep=b.minuteStep||this.element.data("minute-step")||5;this.pickerPosition=b.pickerPosition||this.element.data("picker-position")||"bottom-right";this.showMeridian=b.showMeridian||this.element.data("show-meridian")||!1;this.initialDate=b.initialDate||new Date;this.zIndex=b.zIndex||this.element.data("z-index")||
g;this.title="undefined"===typeof b.title?!1:b.title;this.defaultTimeZone=p();this.timezone=b.timezone||this.defaultTimeZone;this.icons={leftArrow:this.fontAwesome?"fa-arrow-left":3===this.bootcssVer?"glyphicon-arrow-left":"icon-arrow-left",rightArrow:this.fontAwesome?"fa-arrow-right":3===this.bootcssVer?"glyphicon-arrow-right":"icon-arrow-right"};this.icontype=this.fontAwesome?"fa":"glyphicon";this._attachEvents();this.clickedOutside=function(a){0===d(a.target).closest(".datetimepicker").length&&
c.hide()};this.formatViewType="datetime";"formatViewType"in b?this.formatViewType=b.formatViewType:"formatViewType"in this.element.data()&&(this.formatViewType=this.element.data("formatViewType"));this.minView=0;"minView"in b?this.minView=b.minView:"minView"in this.element.data()&&(this.minView=this.element.data("min-view"));this.minView=f.convertViewMode(this.minView);this.maxView=f.modes.length-1;"maxView"in b?this.maxView=b.maxView:"maxView"in this.element.data()&&(this.maxView=this.element.data("max-view"));
this.maxView=f.convertViewMode(this.maxView);this.wheelViewModeNavigation=!1;"wheelViewModeNavigation"in b?this.wheelViewModeNavigation=b.wheelViewModeNavigation:"wheelViewModeNavigation"in this.element.data()&&(this.wheelViewModeNavigation=this.element.data("view-mode-wheel-navigation"));this.wheelViewModeNavigationInverseDirection=!1;"wheelViewModeNavigationInverseDirection"in b?this.wheelViewModeNavigationInverseDirection=b.wheelViewModeNavigationInverseDirection:"wheelViewModeNavigationInverseDirection"in
this.element.data()&&(this.wheelViewModeNavigationInverseDirection=this.element.data("view-mode-wheel-navigation-inverse-dir"));this.wheelViewModeNavigationDelay=100;"wheelViewModeNavigationDelay"in b?this.wheelViewModeNavigationDelay=b.wheelViewModeNavigationDelay:"wheelViewModeNavigationDelay"in this.element.data()&&(this.wheelViewModeNavigationDelay=this.element.data("view-mode-wheel-navigation-delay"));this.startViewMode=2;"startView"in b?this.startViewMode=b.startView:"startView"in this.element.data()&&
(this.startViewMode=this.element.data("start-view"));this.viewMode=this.startViewMode=f.convertViewMode(this.startViewMode);this.viewSelect=this.minView;"viewSelect"in b?this.viewSelect=b.viewSelect:"viewSelect"in this.element.data()&&(this.viewSelect=this.element.data("view-select"));this.viewSelect=f.convertViewMode(this.viewSelect);this.forceParse=!0;"forceParse"in b?this.forceParse=b.forceParse:"dateForceParse"in this.element.data()&&(this.forceParse=this.element.data("date-force-parse"));for(a=
3===this.bootcssVer?f.templateV3:f.template;-1!==a.indexOf("{iconType}");)a=a.replace("{iconType}",this.icontype);for(;-1!==a.indexOf("{leftArrow}");)a=a.replace("{leftArrow}",this.icons.leftArrow);for(;-1!==a.indexOf("{rightArrow}");)a=a.replace("{rightArrow}",this.icons.rightArrow);this.picker=d(a).appendTo(this.isInline?this.element:this.container).on({click:d.proxy(this.click,this),mousedown:d.proxy(this.mousedown,this)});if(this.wheelViewModeNavigation)if(d.fn.mousewheel)this.picker.on({mousewheel:d.proxy(this.mousewheel,
this)});else console.log("Mouse Wheel event is not supported. Please include the jQuery Mouse Wheel plugin before enabling this option");this.isInline?this.picker.addClass("datetimepicker-inline"):this.picker.addClass("datetimepicker-dropdown-"+this.pickerPosition+" dropdown-menu");this.isRTL&&(this.picker.addClass("datetimepicker-rtl"),this.picker.find(3===this.bootcssVer?".prev span, .next span":".prev i, .next i").toggleClass(this.icons.leftArrow+" "+this.icons.rightArrow));d(document).on("mousedown",
this.clickedOutside);this.autoclose=!1;"autoclose"in b?this.autoclose=b.autoclose:"dateAutoclose"in this.element.data()&&(this.autoclose=this.element.data("date-autoclose"));this.keyboardNavigation=!0;"keyboardNavigation"in b?this.keyboardNavigation=b.keyboardNavigation:"dateKeyboardNavigation"in this.element.data()&&(this.keyboardNavigation=this.element.data("date-keyboard-navigation"));this.todayBtn=b.todayBtn||this.element.data("date-today-btn")||!1;this.clearBtn=b.clearBtn||this.element.data("date-clear-btn")||
!1;this.todayHighlight=b.todayHighlight||this.element.data("date-today-highlight")||!1;this.weekStart=(b.weekStart||this.element.data("date-weekstart")||h[this.language].weekStart||0)%7;this.weekEnd=(this.weekStart+6)%7;this.startDate=-Infinity;this.endDate=Infinity;this.datesDisabled=[];this.daysOfWeekDisabled=[];this.setStartDate(b.startDate||this.element.data("date-startdate"));this.setEndDate(b.endDate||this.element.data("date-enddate"));this.setDatesDisabled(b.datesDisabled||this.element.data("date-dates-disabled"));
this.setDaysOfWeekDisabled(b.daysOfWeekDisabled||this.element.data("date-days-of-week-disabled"));this.setMinutesDisabled(b.minutesDisabled||this.element.data("date-minute-disabled"));this.setHoursDisabled(b.hoursDisabled||this.element.data("date-hour-disabled"));this.fillDow();this.fillMonths();this.update();this.showMode();this.isInline&&this.show()};r.prototype={constructor:r,_events:[],_attachEvents:function(){this._detachEvents();this.isInput?this._events=[[this.element,{focus:d.proxy(this.show,
this),keyup:d.proxy(this.update,this),keydown:d.proxy(this.keydown,this)}]]:this.component&&this.hasInput?(this._events=[[this.element.find("input"),{focus:d.proxy(this.show,this),keyup:d.proxy(this.update,this),keydown:d.proxy(this.keydown,this)}],[this.component,{click:d.proxy(this.show,this)}]],this.componentReset&&this._events.push([this.componentReset,{click:d.proxy(this.reset,this)}])):this.element.is("div")?this.isInline=!0:this._events=[[this.element,{click:d.proxy(this.show,this)}]];for(var a=
0,b,c;a<this._events.length;a++)b=this._events[a][0],c=this._events[a][1],b.on(c)},_detachEvents:function(){for(var a=0,b,c;a<this._events.length;a++)b=this._events[a][0],c=this._events[a][1],b.off(c);this._events=[]},show:function(a){this.picker.show();this.height=this.component?this.component.outerHeight():this.element.outerHeight();this.forceParse&&this.update();this.place();d(window).on("resize",d.proxy(this.place,this));a&&(a.stopPropagation(),a.preventDefault());this.isVisible=!0;this.element.trigger({type:"show",
date:this.date})},hide:function(a){this.isVisible&&!this.isInline&&(this.picker.hide(),d(window).off("resize",this.place),this.viewMode=this.startViewMode,this.showMode(),this.isInput||d(document).off("mousedown",this.hide),this.forceParse&&(this.isInput&&this.element.val()||this.hasInput&&this.element.find("input").val())&&this.setValue(),this.isVisible=!1,this.element.trigger({type:"hide",date:this.date}))},remove:function(){this._detachEvents();d(document).off("mousedown",this.clickedOutside);
this.picker.remove();delete this.picker;delete this.element.data().datetimepicker},getDate:function(){var a=this.getUTCDate();return new Date(a.getTime()+6E4*a.getTimezoneOffset())},getUTCDate:function(){return this.date},getInitialDate:function(){return this.initialDate},setInitialDate:function(a){this.initialDate=a},setDate:function(a){this.setUTCDate(new Date(a.getTime()-6E4*a.getTimezoneOffset()))},setUTCDate:function(a){a>=this.startDate&&a<=this.endDate?(this.date=a,this.setValue(),this.viewDate=
this.date,this.fill()):this.element.trigger({type:"outOfRange",date:a,startDate:this.startDate,endDate:this.endDate})},setFormat:function(a){this.format=f.parseFormat(a,this.formatType);var b;this.isInput?b=this.element:this.component&&(b=this.element.find("input"));b&&b.val()&&this.setValue()},setValue:function(){var a=this.getFormattedDate();this.isInput?this.element.val(a):(this.component&&this.element.find("input").val(a),this.element.data("date",a));this.linkField&&d("#"+this.linkField).val(this.getFormattedDate(this.linkFormat))},
getFormattedDate:function(a){a==g&&(a=this.format);return f.formatDate(this.date,a,this.language,this.formatType,this.timezone)},setStartDate:function(a){this.startDate=a||-Infinity;-Infinity!==this.startDate&&(this.startDate=f.parseDate(this.startDate,this.format,this.language,this.formatType,this.timezone));this.update();this.updateNavArrows()},setEndDate:function(a){this.endDate=a||Infinity;Infinity!==this.endDate&&(this.endDate=f.parseDate(this.endDate,this.format,this.language,this.formatType,
this.timezone));this.update();this.updateNavArrows()},setDatesDisabled:function(a){this.datesDisabled=a||[];d.isArray(this.datesDisabled)||(this.datesDisabled=this.datesDisabled.split(/,\s*/));this.datesDisabled=d.map(this.datesDisabled,function(a){return f.parseDate(a,this.format,this.language,this.formatType,this.timezone).toDateString()});this.update();this.updateNavArrows()},setTitle:function(a,b){return this.picker.find(a).find("th:eq(1)").text(!1===this.title?b:this.title)},setDaysOfWeekDisabled:function(a){this.daysOfWeekDisabled=
a||[];d.isArray(this.daysOfWeekDisabled)||(this.daysOfWeekDisabled=this.daysOfWeekDisabled.split(/,\s*/));this.daysOfWeekDisabled=d.map(this.daysOfWeekDisabled,function(a){return parseInt(a,10)});this.update();this.updateNavArrows()},setMinutesDisabled:function(a){this.minutesDisabled=a||[];d.isArray(this.minutesDisabled)||(this.minutesDisabled=this.minutesDisabled.split(/,\s*/));this.minutesDisabled=d.map(this.minutesDisabled,function(a){return parseInt(a,10)});this.update();this.updateNavArrows()},
setHoursDisabled:function(a){this.hoursDisabled=a||[];d.isArray(this.hoursDisabled)||(this.hoursDisabled=this.hoursDisabled.split(/,\s*/));this.hoursDisabled=d.map(this.hoursDisabled,function(a){return parseInt(a,10)});this.update();this.updateNavArrows()},place:function(){if(!this.isInline){if(!this.zIndex){var a=0;d("div").each(function(){var b=parseInt(d(this).css("zIndex"),10);b>a&&(a=b)});this.zIndex=a+10}var b=this.container instanceof d?this.container.offset():d(this.container).offset();if(this.component){var c=
this.component.offset();var e=c.left;if("bottom-left"==this.pickerPosition||"top-left"==this.pickerPosition)e+=this.component.outerWidth()-this.picker.outerWidth()}else if(c=this.element.offset(),e=c.left,"bottom-left"==this.pickerPosition||"top-left"==this.pickerPosition)e+=this.element.outerWidth()-this.picker.outerWidth();var k=document.body.clientWidth||window.innerWidth;e+220>k&&(e=k-220);c="top-left"==this.pickerPosition||"top-right"==this.pickerPosition?c.top-this.picker.outerHeight():c.top+
this.height;c-=b.top;e-=b.left;this.picker.css({top:c,left:e,zIndex:this.zIndex})}},update:function(){var a=!1;if(arguments&&arguments.length&&("string"===typeof arguments[0]||arguments[0]instanceof Date)){var b=arguments[0];a=!0}else if(b=(this.isInput?this.element.val():this.element.find("input").val())||this.element.data("date")||this.initialDate,"string"==typeof b||b instanceof String)b=b.replace(/^\s+|\s+$/g,"");b||(b=new Date,a=!1);this.date=f.parseDate(b,this.format,this.language,this.formatType,
this.timezone);a&&this.setValue();this.viewDate=this.date<this.startDate?new Date(this.startDate):this.date>this.endDate?new Date(this.endDate):new Date(this.date);this.fill()},fillDow:function(){for(var a=this.weekStart,b="<tr>";a<this.weekStart+7;)b+='<th class="dow">'+h[this.language].daysMin[a++%7]+"</th>";b+="</tr>";this.picker.find(".datetimepicker-days thead").append(b)},fillMonths:function(){for(var a="",b=0;12>b;)a+='<span class="month">'+h[this.language].monthsShort[b++]+"</span>";this.picker.find(".datetimepicker-months td").html(a)},
fill:function(){if(null!=this.date&&null!=this.viewDate){var a=new Date(this.viewDate),b=a.getUTCFullYear(),c=a.getUTCMonth(),e=a.getUTCDate(),k=a.getUTCHours(),x=a.getUTCMinutes();a=-Infinity!==this.startDate?this.startDate.getUTCFullYear():-Infinity;var w=-Infinity!==this.startDate?this.startDate.getUTCMonth():-Infinity,r=Infinity!==this.endDate?this.endDate.getUTCFullYear():Infinity,p=Infinity!==this.endDate?this.endDate.getUTCMonth()+1:Infinity,l=(new m(this.date.getUTCFullYear(),this.date.getUTCMonth(),
this.date.getUTCDate())).valueOf(),g=new Date;this.setTitle(".datetimepicker-days",h[this.language].months[c]+" "+b);if("time"==this.formatViewType){var n=this.getFormattedDate();this.setTitle(".datetimepicker-hours",n);this.setTitle(".datetimepicker-minutes",n)}else this.setTitle(".datetimepicker-hours",e+" "+h[this.language].months[c]+" "+b),this.setTitle(".datetimepicker-minutes",e+" "+h[this.language].months[c]+" "+b);this.picker.find("tfoot th.today").text(h[this.language].today||h.en.today).toggle(!1!==
this.todayBtn);this.picker.find("tfoot th.clear").text(h[this.language].clear||h.en.clear).toggle(!1!==this.clearBtn);this.updateNavArrows();this.fillMonths();var q=m(b,c-1,28,0,0,0,0);n=f.getDaysInMonth(q.getUTCFullYear(),q.getUTCMonth());q.setUTCDate(n);q.setUTCDate(n-(q.getUTCDay()-this.weekStart+7)%7);var t=new Date(q);t.setUTCDate(t.getUTCDate()+42);t=t.valueOf();n=[];for(var u;q.valueOf()<t;){q.getUTCDay()==this.weekStart&&n.push("<tr>");u="";if(q.getUTCFullYear()<b||q.getUTCFullYear()==b&&
q.getUTCMonth()<c)u+=" old";else if(q.getUTCFullYear()>b||q.getUTCFullYear()==b&&q.getUTCMonth()>c)u+=" new";this.todayHighlight&&q.getUTCFullYear()==g.getFullYear()&&q.getUTCMonth()==g.getMonth()&&q.getUTCDate()==g.getDate()&&(u+=" today");q.valueOf()==l&&(u+=" active");if(q.valueOf()+864E5<=this.startDate||q.valueOf()>this.endDate||-1!==d.inArray(q.getUTCDay(),this.daysOfWeekDisabled)||-1!==d.inArray(q.toDateString(),this.datesDisabled))u+=" disabled";n.push('<td class="day'+u+'">'+q.getUTCDate()+
"</td>");q.getUTCDay()==this.weekEnd&&n.push("</tr>");q.setUTCDate(q.getUTCDate()+1)}this.picker.find(".datetimepicker-days tbody").empty().append(n.join(""));n=[];g="";q=this.hoursDisabled||[];for(l=0;24>l;l++)-1===q.indexOf(l)&&(t=m(b,c,e,l),u="",t.valueOf()+36E5<=this.startDate||t.valueOf()>this.endDate?u+=" disabled":k==l&&(u+=" active"),this.showMeridian&&2==h[this.language].meridiem.length?(t=12>l?h[this.language].meridiem[0]:h[this.language].meridiem[1],t!=g&&(""!=g&&n.push("</fieldset>"),
n.push('<fieldset class="hour"><legend>'+t.toUpperCase()+"</legend>")),g=t,t=l%12?l%12:12,n.push('<span class="hour'+u+" hour_"+(12>l?"am":"pm")+'">'+t+"</span>"),23==l&&n.push("</fieldset>")):(t=l+":00",n.push('<span class="hour'+u+'">'+t+"</span>")));this.picker.find(".datetimepicker-hours td").html(n.join(""));n=[];g="";q=this.minutesDisabled||[];for(l=0;60>l;l+=this.minuteStep)-1===q.indexOf(l)&&(t=m(b,c,e,k,l,0),u="",t.valueOf()<this.startDate||t.valueOf()>this.endDate?u+=" disabled":Math.floor(x/
this.minuteStep)==Math.floor(l/this.minuteStep)&&(u+=" active"),this.showMeridian&&2==h[this.language].meridiem.length?(t=12>k?h[this.language].meridiem[0]:h[this.language].meridiem[1],t!=g&&(""!=g&&n.push("</fieldset>"),n.push('<fieldset class="minute"><legend>'+t.toUpperCase()+"</legend>")),g=t,t=k%12?k%12:12,n.push('<span class="minute'+u+'">'+t+":"+(10>l?"0"+l:l)+"</span>"),59==l&&n.push("</fieldset>")):n.push('<span class="minute'+u+'">'+k+":"+(10>l?"0"+l:l)+"</span>"));this.picker.find(".datetimepicker-minutes td").html(n.join(""));
c=this.date.getUTCFullYear();e=this.setTitle(".datetimepicker-months",b).end().find("span").removeClass("active");c==b&&(k=e.length-12,e.eq(this.date.getUTCMonth()+k).addClass("active"));(b<a||b>r)&&e.addClass("disabled");b==a&&e.slice(0,w).addClass("disabled");b==r&&e.slice(p).addClass("disabled");n="";b=10*parseInt(b/10,10);w=this.setTitle(".datetimepicker-years",b+"-"+(b+9)).end().find("td");--b;for(l=-1;11>l;l++)n+='<span class="year'+(-1==l||10==l?" old":"")+(c==b?" active":"")+(b<a||b>r?" disabled":
"")+'">'+b+"</span>",b+=1;w.html(n);this.place()}},updateNavArrows:function(){var a=new Date(this.viewDate),b=a.getUTCFullYear(),c=a.getUTCMonth(),e=a.getUTCDate();a=a.getUTCHours();switch(this.viewMode){case 0:-Infinity!==this.startDate&&b<=this.startDate.getUTCFullYear()&&c<=this.startDate.getUTCMonth()&&e<=this.startDate.getUTCDate()&&a<=this.startDate.getUTCHours()?this.picker.find(".prev").css({visibility:"hidden"}):this.picker.find(".prev").css({visibility:"visible"});Infinity!==this.endDate&&
b>=this.endDate.getUTCFullYear()&&c>=this.endDate.getUTCMonth()&&e>=this.endDate.getUTCDate()&&a>=this.endDate.getUTCHours()?this.picker.find(".next").css({visibility:"hidden"}):this.picker.find(".next").css({visibility:"visible"});break;case 1:-Infinity!==this.startDate&&b<=this.startDate.getUTCFullYear()&&c<=this.startDate.getUTCMonth()&&e<=this.startDate.getUTCDate()?this.picker.find(".prev").css({visibility:"hidden"}):this.picker.find(".prev").css({visibility:"visible"});Infinity!==this.endDate&&
b>=this.endDate.getUTCFullYear()&&c>=this.endDate.getUTCMonth()&&e>=this.endDate.getUTCDate()?this.picker.find(".next").css({visibility:"hidden"}):this.picker.find(".next").css({visibility:"visible"});break;case 2:-Infinity!==this.startDate&&b<=this.startDate.getUTCFullYear()&&c<=this.startDate.getUTCMonth()?this.picker.find(".prev").css({visibility:"hidden"}):this.picker.find(".prev").css({visibility:"visible"});Infinity!==this.endDate&&b>=this.endDate.getUTCFullYear()&&c>=this.endDate.getUTCMonth()?
this.picker.find(".next").css({visibility:"hidden"}):this.picker.find(".next").css({visibility:"visible"});break;case 3:case 4:-Infinity!==this.startDate&&b<=this.startDate.getUTCFullYear()?this.picker.find(".prev").css({visibility:"hidden"}):this.picker.find(".prev").css({visibility:"visible"}),Infinity!==this.endDate&&b>=this.endDate.getUTCFullYear()?this.picker.find(".next").css({visibility:"hidden"}):this.picker.find(".next").css({visibility:"visible"})}},mousewheel:function(a){a.preventDefault();
a.stopPropagation();this.wheelPause||(this.wheelPause=!0,a=a.originalEvent.wheelDelta,a=0<a?1:0===a?0:-1,this.wheelViewModeNavigationInverseDirection&&(a=-a),this.showMode(a),setTimeout(d.proxy(function(){this.wheelPause=!1},this),this.wheelViewModeNavigationDelay))},click:function(a){a.stopPropagation();a.preventDefault();a=d(a.target).closest("span, td, th, legend");a.is("."+this.icontype)&&(a=d(a).parent().closest("span, td, th, legend"));if(1==a.length)if(a.is(".disabled"))this.element.trigger({type:"outOfRange",
date:this.viewDate,startDate:this.startDate,endDate:this.endDate});else switch(a[0].nodeName.toLowerCase()){case "th":switch(a[0].className){case "switch":this.showMode(1);break;case "prev":case "next":var b=f.modes[this.viewMode].navStep*("prev"==a[0].className?-1:1);switch(this.viewMode){case 0:this.viewDate=this.moveHour(this.viewDate,b);break;case 1:this.viewDate=this.moveDate(this.viewDate,b);break;case 2:this.viewDate=this.moveMonth(this.viewDate,b);break;case 3:case 4:this.viewDate=this.moveYear(this.viewDate,
b)}this.fill();this.element.trigger({type:a[0].className+":"+this.convertViewModeText(this.viewMode),date:this.viewDate,startDate:this.startDate,endDate:this.endDate});break;case "clear":this.reset();this.autoclose&&this.hide();break;case "today":a=new Date,a=m(a.getFullYear(),a.getMonth(),a.getDate(),a.getHours(),a.getMinutes(),a.getSeconds(),0),a<this.startDate?a=this.startDate:a>this.endDate&&(a=this.endDate),this.viewMode=this.startViewMode,this.showMode(0),this._setDate(a),this.fill(),this.autoclose&&
this.hide()}break;case "span":if(!a.is(".disabled")){b=this.viewDate.getUTCFullYear();var c=this.viewDate.getUTCMonth(),e=this.viewDate.getUTCDate(),k=this.viewDate.getUTCHours(),h=this.viewDate.getUTCMinutes(),g=this.viewDate.getUTCSeconds();if(a.is(".month"))this.viewDate.setUTCDate(1),c=a.parent().find("span").index(a),e=this.viewDate.getUTCDate(),this.viewDate.setUTCMonth(c),this.element.trigger({type:"changeMonth",date:this.viewDate}),3<=this.viewSelect&&this._setDate(m(b,c,e,k,h,g,0));else if(a.is(".year"))this.viewDate.setUTCDate(1),
b=parseInt(a.text(),10)||0,this.viewDate.setUTCFullYear(b),this.element.trigger({type:"changeYear",date:this.viewDate}),4<=this.viewSelect&&this._setDate(m(b,c,e,k,h,g,0));else if(a.is(".hour")){k=parseInt(a.text(),10)||0;if(a.hasClass("hour_am")||a.hasClass("hour_pm"))12==k&&a.hasClass("hour_am")?k=0:12!=k&&a.hasClass("hour_pm")&&(k+=12);this.viewDate.setUTCHours(k);this.element.trigger({type:"changeHour",date:this.viewDate});1<=this.viewSelect&&this._setDate(m(b,c,e,k,h,g,0))}else a.is(".minute")&&
(h=parseInt(a.text().substr(a.text().indexOf(":")+1),10)||0,this.viewDate.setUTCMinutes(h),this.element.trigger({type:"changeMinute",date:this.viewDate}),0<=this.viewSelect&&this._setDate(m(b,c,e,k,h,g,0)));0!=this.viewMode?(a=this.viewMode,this.showMode(-1),this.fill(),a==this.viewMode&&this.autoclose&&this.hide()):(this.fill(),this.autoclose&&this.hide())}break;case "td":a.is(".day")&&!a.is(".disabled")&&(e=parseInt(a.text(),10)||1,b=this.viewDate.getUTCFullYear(),c=this.viewDate.getUTCMonth(),
k=this.viewDate.getUTCHours(),h=this.viewDate.getUTCMinutes(),g=this.viewDate.getUTCSeconds(),a.is(".old")?0===c?(c=11,--b):--c:a.is(".new")&&(11==c?(c=0,b+=1):c+=1),this.viewDate.setUTCFullYear(b),this.viewDate.setUTCMonth(c,e),this.element.trigger({type:"changeDay",date:this.viewDate}),2<=this.viewSelect&&this._setDate(m(b,c,e,k,h,g,0))),a=this.viewMode,this.showMode(-1),this.fill(),a==this.viewMode&&this.autoclose&&this.hide()}},_setDate:function(a,b){b&&"date"!=b||(this.date=a);b&&"view"!=b||
(this.viewDate=a);this.fill();this.setValue();var c;this.isInput?c=this.element:this.component&&(c=this.element.find("input"));c&&c.change();this.element.trigger({type:"changeDate",date:this.getDate()});null==a&&(this.date=this.viewDate)},moveMinute:function(a,b){if(!b)return a;a=new Date(a.valueOf());a.setUTCMinutes(a.getUTCMinutes()+b*this.minuteStep);return a},moveHour:function(a,b){if(!b)return a;a=new Date(a.valueOf());a.setUTCHours(a.getUTCHours()+b);return a},moveDate:function(a,b){if(!b)return a;
a=new Date(a.valueOf());a.setUTCDate(a.getUTCDate()+b);return a},moveMonth:function(a,b){if(!b)return a;var c=new Date(a.valueOf());a=c.getUTCDate();var e=c.getUTCMonth(),d=Math.abs(b);b=0<b?1:-1;if(1==d){d=-1==b?function(){return c.getUTCMonth()==e}:function(){return c.getUTCMonth()!=f};var f=e+b;c.setUTCMonth(f);if(0>f||11<f)f=(f+12)%12}else{for(var h=0;h<d;h++)c=this.moveMonth(c,b);f=c.getUTCMonth();c.setUTCDate(a);d=function(){return f!=c.getUTCMonth()}}for(;d();)c.setUTCDate(--a),c.setUTCMonth(f);
return c},moveYear:function(a,b){return this.moveMonth(a,12*b)},dateWithinRange:function(a){return a>=this.startDate&&a<=this.endDate},keydown:function(a){if(this.picker.is(":not(:visible)"))27==a.keyCode&&this.show();else{var b=!1;switch(a.keyCode){case 27:this.hide();a.preventDefault();break;case 37:case 39:if(!this.keyboardNavigation)break;var c=37==a.keyCode?-1:1;viewMode=this.viewMode;a.ctrlKey?viewMode+=2:a.shiftKey&&(viewMode+=1);if(4==viewMode){var e=this.moveYear(this.date,c);var d=this.moveYear(this.viewDate,
c)}else 3==viewMode?(e=this.moveMonth(this.date,c),d=this.moveMonth(this.viewDate,c)):2==viewMode?(e=this.moveDate(this.date,c),d=this.moveDate(this.viewDate,c)):1==viewMode?(e=this.moveHour(this.date,c),d=this.moveHour(this.viewDate,c)):0==viewMode&&(e=this.moveMinute(this.date,c),d=this.moveMinute(this.viewDate,c));this.dateWithinRange(e)&&(this.date=e,this.viewDate=d,this.setValue(),this.update(),a.preventDefault(),b=!0);break;case 38:case 40:if(!this.keyboardNavigation)break;c=38==a.keyCode?-1:
1;viewMode=this.viewMode;a.ctrlKey?viewMode+=2:a.shiftKey&&(viewMode+=1);4==viewMode?(e=this.moveYear(this.date,c),d=this.moveYear(this.viewDate,c)):3==viewMode?(e=this.moveMonth(this.date,c),d=this.moveMonth(this.viewDate,c)):2==viewMode?(e=this.moveDate(this.date,7*c),d=this.moveDate(this.viewDate,7*c)):1==viewMode?this.showMeridian?(e=this.moveHour(this.date,6*c),d=this.moveHour(this.viewDate,6*c)):(e=this.moveHour(this.date,4*c),d=this.moveHour(this.viewDate,4*c)):0==viewMode&&(e=this.moveMinute(this.date,
4*c),d=this.moveMinute(this.viewDate,4*c));this.dateWithinRange(e)&&(this.date=e,this.viewDate=d,this.setValue(),this.update(),a.preventDefault(),b=!0);break;case 13:0!=this.viewMode?(c=this.viewMode,this.showMode(-1),this.fill(),c==this.viewMode&&this.autoclose&&this.hide()):(this.fill(),this.autoclose&&this.hide());a.preventDefault();break;case 9:this.hide()}if(b){var f;this.isInput?f=this.element:this.component&&(f=this.element.find("input"));f&&f.change();this.element.trigger({type:"changeDate",
date:this.getDate()})}}},showMode:function(a){a&&(a=Math.max(0,Math.min(f.modes.length-1,this.viewMode+a)),a>=this.minView&&a<=this.maxView&&(this.element.trigger({type:"changeMode",date:this.viewDate,oldViewMode:this.viewMode,newViewMode:a}),this.viewMode=a));this.picker.find(">div").hide().filter(".datetimepicker-"+f.modes[this.viewMode].clsName).css("display","block");this.updateNavArrows()},reset:function(a){this._setDate(null,"date")},convertViewModeText:function(a){switch(a){case 4:return"decade";
case 3:return"year";case 2:return"month";case 1:return"day";case 0:return"hour"}}};var v=d.fn.datetimepicker;d.fn.datetimepicker=function(a){var b=Array.apply(null,arguments);b.shift();var c;this.each(function(){var e=d(this),f=e.data("datetimepicker"),h="object"==typeof a&&a;f||e.data("datetimepicker",f=new r(this,d.extend({},d.fn.datetimepicker.defaults,h)));if("string"==typeof a&&"function"==typeof f[a]&&(c=f[a].apply(f,b),c!==g))return!1});return c!==g?c:this};d.fn.datetimepicker.defaults={};
d.fn.datetimepicker.Constructor=r;var h=d.fn.datetimepicker.dates={en:{days:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday Sunday".split(" "),daysShort:"Sun Mon Tue Wed Thu Fri Sat Sun".split(" "),daysMin:"Su Mo Tu We Th Fr Sa Su".split(" "),months:"January February March April May June July August September October November December".split(" "),monthsShort:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),meridiem:["am","pm"],suffix:["st","nd","rd","th"],today:"Today",clear:"Clear"}},
f={modes:[{clsName:"minutes",navFnc:"Hours",navStep:1},{clsName:"hours",navFnc:"Date",navStep:1},{clsName:"days",navFnc:"Month",navStep:1},{clsName:"months",navFnc:"FullYear",navStep:1},{clsName:"years",navFnc:"FullYear",navStep:10}],isLeapYear:function(a){return 0===a%4&&0!==a%100||0===a%400},getDaysInMonth:function(a,b){return[31,f.isLeapYear(a)?29:28,31,30,31,30,31,31,30,31,30,31][b]},getDefaultFormat:function(a,b){if("standard"==a)return"input"==b?"yyyy-mm-dd hh:ii":"yyyy-mm-dd hh:ii:ss";if("php"==
a)return"input"==b?"Y-m-d H:i":"Y-m-d H:i:s";throw Error("Invalid format type.");},validParts:function(a){if("standard"==a)return/t|hh?|HH?|p|P|z|Z|ii?|ss?|dd?|DD?|mm?|MM?|yy(?:yy)?/g;if("php"==a)return/[dDjlNwzFmMnStyYaABgGhHis]/g;throw Error("Invalid format type.");},nonpunctuation:/[^ -\/:-@\[-`{-~\t\n\rTZ]+/g,parseFormat:function(a,b){var c=a.replace(this.validParts(b),"\x00").split("\x00");a=a.match(this.validParts(b));if(!c||!c.length||!a||0==a.length)throw Error("Invalid date format.");return{separators:c,
parts:a}},parseDate:function(a,b,c,e,f){if(a instanceof Date)return a=new Date(a.valueOf()-6E4*a.getTimezoneOffset()),a.setMilliseconds(0),a;/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(a)&&(b=this.parseFormat("yyyy-mm-dd",e));/^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}:\d{1,2}$/.test(a)&&(b=this.parseFormat("yyyy-mm-dd hh:ii",e));/^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}:\d{1,2}:\d{1,2}[Z]{0,1}$/.test(a)&&(b=this.parseFormat("yyyy-mm-dd hh:ii:ss",e));if(/^[-+]\d+[dmwy]([\s,]+[-+]\d+[dmwy])*$/.test(a)){b=/([-+]\d+)([dmwy])/;
var g=a.match(/([-+]\d+)([dmwy])/g);a=new Date;for(var k=0;k<g.length;k++)switch(e=b.exec(g[k]),c=parseInt(e[1]),e[2]){case "d":a.setUTCDate(a.getUTCDate()+c);break;case "m":a=r.prototype.moveMonth.call(r.prototype,a,c);break;case "w":a.setUTCDate(a.getUTCDate()+7*c);break;case "y":a=r.prototype.moveYear.call(r.prototype,a,c)}return m(a.getUTCFullYear(),a.getUTCMonth(),a.getUTCDate(),a.getUTCHours(),a.getUTCMinutes(),a.getUTCSeconds(),0)}g=a&&a.toString().match(this.nonpunctuation)||[];a=new Date(0,
0,0,0,0,0,0);var p={},v="hh h ii i ss s yyyy yy M MM m mm D DD d dd H HH p P z Z".split(" "),l={hh:function(a,b){return a.setUTCHours(b)},h:function(a,b){return a.setUTCHours(b)},HH:function(a,b){return a.setUTCHours(12==b?0:b)},H:function(a,b){return a.setUTCHours(12==b?0:b)},ii:function(a,b){return a.setUTCMinutes(b)},i:function(a,b){return a.setUTCMinutes(b)},ss:function(a,b){return a.setUTCSeconds(b)},s:function(a,b){return a.setUTCSeconds(b)},yyyy:function(a,b){return a.setUTCFullYear(b)},yy:function(a,
b){return a.setUTCFullYear(2E3+b)},m:function(a,b){for(--b;0>b;)b+=12;b%=12;for(a.setUTCMonth(b);a.getUTCMonth()!=b&&!isNaN(a.getUTCMonth());)a.setUTCDate(a.getUTCDate()-1);return a},d:function(a,b){return a.setUTCDate(b)},p:function(a,b){return a.setUTCHours(1==b?a.getUTCHours()+12:a.getUTCHours())},z:function(){return f}};l.M=l.MM=l.mm=l.m;l.dd=l.d;l.P=l.p;l.Z=l.z;a=m(a.getFullYear(),a.getMonth(),a.getDate(),a.getHours(),a.getMinutes(),a.getSeconds());if(g.length==b.parts.length){k=0;for(var y=
b.parts.length;k<y;k++){var n=parseInt(g[k],10);e=b.parts[k];if(isNaN(n))switch(e){case "MM":n=d(h[c].months).filter(function(){var a=this.slice(0,g[k].length),b=g[k].slice(0,a.length);return a==b});n=d.inArray(n[0],h[c].months)+1;break;case "M":n=d(h[c].monthsShort).filter(function(){var a=this.slice(0,g[k].length),b=g[k].slice(0,a.length);return a.toLowerCase()==b.toLowerCase()});n=d.inArray(n[0],h[c].monthsShort)+1;break;case "p":case "P":n=d.inArray(g[k].toLowerCase(),h[c].meridiem);break;case "z":case "Z":f}p[e]=
n}for(k=0;k<v.length;k++)if(e=v[k],e in p&&!isNaN(p[e]))l[e](a,p[e])}return a},formatDate:function(a,b,c,e,g){if(null==a)return"";if("standard"==e)e={t:a.getTime(),yy:a.getUTCFullYear().toString().substring(2),yyyy:a.getUTCFullYear(),m:a.getUTCMonth()+1,M:h[c].monthsShort[a.getUTCMonth()],MM:h[c].months[a.getUTCMonth()],d:a.getUTCDate(),D:h[c].daysShort[a.getUTCDay()],DD:h[c].days[a.getUTCDay()],p:2==h[c].meridiem.length?h[c].meridiem[12>a.getUTCHours()?0:1]:"",h:a.getUTCHours(),i:a.getUTCMinutes(),
s:a.getUTCSeconds(),z:g},e.H=2==h[c].meridiem.length?0==e.h%12?12:e.h%12:e.h,e.HH=(10>e.H?"0":"")+e.H,e.P=e.p.toUpperCase(),e.Z=e.z,e.hh=(10>e.h?"0":"")+e.h,e.ii=(10>e.i?"0":"")+e.i,e.ss=(10>e.s?"0":"")+e.s,e.dd=(10>e.d?"0":"")+e.d,e.mm=(10>e.m?"0":"")+e.m;else if("php"==e)e={y:a.getUTCFullYear().toString().substring(2),Y:a.getUTCFullYear(),F:h[c].months[a.getUTCMonth()],M:h[c].monthsShort[a.getUTCMonth()],n:a.getUTCMonth()+1,t:f.getDaysInMonth(a.getUTCFullYear(),a.getUTCMonth()),j:a.getUTCDate(),
l:h[c].days[a.getUTCDay()],D:h[c].daysShort[a.getUTCDay()],w:a.getUTCDay(),N:0==a.getUTCDay()?7:a.getUTCDay(),S:a.getUTCDate()%10<=h[c].suffix.length?h[c].suffix[a.getUTCDate()%10-1]:"",a:2==h[c].meridiem.length?h[c].meridiem[12>a.getUTCHours()?0:1]:"",g:0==a.getUTCHours()%12?12:a.getUTCHours()%12,G:a.getUTCHours(),i:a.getUTCMinutes(),s:a.getUTCSeconds()},e.m=(10>e.n?"0":"")+e.n,e.d=(10>e.j?"0":"")+e.j,e.A=e.a.toString().toUpperCase(),e.h=(10>e.g?"0":"")+e.g,e.H=(10>e.G?"0":"")+e.G,e.i=(10>e.i?"0":
"")+e.i,e.s=(10>e.s?"0":"")+e.s;else throw Error("Invalid format type.");a=[];c=d.extend([],b.separators);g=0;for(var k=b.parts.length;g<k;g++)c.length&&a.push(c.shift()),a.push(e[b.parts[g]]);c.length&&a.push(c.shift());return a.join("")},convertViewMode:function(a){switch(a){case 4:case "decade":a=4;break;case 3:case "year":a=3;break;case 2:case "month":a=2;break;case 1:case "day":a=1;break;case 0:case "hour":a=0}return a},headTemplate:'<thead><tr><th class="prev"><i class="{iconType} {leftArrow}"/></th><th colspan="5" class="switch"></th><th class="next"><i class="{iconType} {rightArrow}"/></th></tr></thead>',
headTemplateV3:'<thead><tr><th class="prev"><span class="{iconType} {leftArrow}"></span> </th><th colspan="5" class="switch"></th><th class="next"><span class="{iconType} {rightArrow}"></span> </th></tr></thead>',contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>',footTemplate:'<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'};f.template='<div class="datetimepicker"><div class="datetimepicker-minutes"><table class=" table-condensed">'+
f.headTemplate+f.contTemplate+f.footTemplate+'</table></div><div class="datetimepicker-hours"><table class=" table-condensed">'+f.headTemplate+f.contTemplate+f.footTemplate+'</table></div><div class="datetimepicker-days"><table class=" table-condensed">'+f.headTemplate+"<tbody></tbody>"+f.footTemplate+'</table></div><div class="datetimepicker-months"><table class="table-condensed">'+f.headTemplate+f.contTemplate+f.footTemplate+'</table></div><div class="datetimepicker-years"><table class="table-condensed">'+
f.headTemplate+f.contTemplate+f.footTemplate+"</table></div></div>";f.templateV3='<div class="datetimepicker"><div class="datetimepicker-minutes"><table class=" table-condensed">'+f.headTemplateV3+f.contTemplate+f.footTemplate+'</table></div><div class="datetimepicker-hours"><table class=" table-condensed">'+f.headTemplateV3+f.contTemplate+f.footTemplate+'</table></div><div class="datetimepicker-days"><table class=" table-condensed">'+f.headTemplateV3+"<tbody></tbody>"+f.footTemplate+'</table></div><div class="datetimepicker-months"><table class="table-condensed">'+
f.headTemplateV3+f.contTemplate+f.footTemplate+'</table></div><div class="datetimepicker-years"><table class="table-condensed">'+f.headTemplateV3+f.contTemplate+f.footTemplate+"</table></div></div>";d.fn.datetimepicker.DPGlobal=f;d.fn.datetimepicker.noConflict=function(){d.fn.datetimepicker=v;return this};d(document).on("focus.datetimepicker.data-api click.datetimepicker.data-api",'[data-provide="datetimepicker"]',function(a){var b=d(this);b.data("datetimepicker")||(a.preventDefault(),b.datetimepicker("show"))});
d(function(){d('[data-provide="datetimepicker-inline"]').datetimepicker()})});var kvInitHtml5;(function(d){kvInitHtml5=function(g,m){var p=d(g),r=d(m);d(document).on("change",g,function(){r.val(this.value)}).on("input change",m,function(d){p.val(this.value);"change"===d.type&&p.trigger("change")})}})(window.jQuery);
