// Avoid `console` errors in browsers that lack a console.
(!window.console||!console.log)&&function(){var e=function(){},t=["assert","clear","count","debug","dir","dirxml","error","exception","group","groupCollapsed","groupEnd","info","log","markTimeline","profile","profileEnd","markTimeline","table","time","timeEnd","timeStamp","trace","warn"],n=t.length,r=window.console={};while(n--)r[t[n]]=e}();var Placeholders=function(){function e(e){var t=e.getElementsByTagName("input"),n=e.getElementsByTagName("textarea"),r=t.length,i=r+n.length,s,o,u;for(u=0;u<i;u++){s=u<r?t[u]:n[u-r];o=s.getAttribute("placeholder");s.value===o&&(s.value="")}}function t(e){if(e.value===""){e.className=e.className+" placeholderspolyfill";e.value=e.getAttribute("placeholder")}}function n(e){if(e.value===e.getAttribute("placeholder")){e.className=e.className.replace(/\bplaceholderspolyfill\b/,"");e.value=""}}function r(e){if(e.addEventListener){e.addEventListener("focus",function(){n(e)},!1);e.addEventListener("blur",function(){t(e)},!1)}else if(e.attachEvent){e.attachEvent("onfocus",function(){n(e)});e.attachEvent("onblur",function(){t(e)})}}function i(){var e=document.getElementsByTagName("input"),t=document.getElementsByTagName("textarea"),n=e.length,i=n+t.length,s,o,a,l;for(s=0;s<i;s++){o=s<n?e[s]:t[s-n];l=o.getAttribute("placeholder");if(u.indexOf(o.type)===-1&&l){a=o.getAttribute("data-currentplaceholder");if(l!==a){if(o.value===a||o.value===l||!o.value){o.value=l;o.className=o.className+" placeholderspolyfill"}a||r(o);o.setAttribute("data-currentplaceholder",l)}}}}function s(){var t=document.getElementsByTagName("input"),n=document.getElementsByTagName("textarea"),i=t.length,s=i+n.length,o,a,l,c;for(o=0;o<s;o++){a=o<i?t[o]:n[o-i];c=a.getAttribute("placeholder");if(u.indexOf(a.type)===-1&&c){a.setAttribute("data-currentplaceholder",c);if(a.value===""||a.value===c){a.className=a.className+" placeholderspolyfill";a.value=c}if(a.form){l=a.form;if(!l.getAttribute("data-placeholdersubmit")){l.addEventListener?l.addEventListener("submit",function(){e(l)},!1):l.attachEvent&&l.attachEvent("onsubmit",function(){e(l)});l.setAttribute("data-placeholdersubmit","true")}}r(a)}}}function o(e){var t=document.createElement("input"),n,r,o,u;if(typeof t.placeholder=="undefined"){n=document.createElement("style");n.type="text/css";r=document.createTextNode(".placeholderspolyfill { color:#999 !important; }");n.styleSheet?n.styleSheet.cssText=r.nodeValue:n.appendChild(r);document.getElementsByTagName("head")[0].appendChild(n);Array.prototype.indexOf||(Array.prototype.indexOf=function(e,t){for(o=t||0,u=this.length;o<u;o++)if(this[o]===e)return o;return-1});s();e&&(a=setInterval(i,100))}return!1}var u=["hidden","datetime","date","month","week","time","datetime-local","range","color","checkbox","radio","file","submit","image","reset","button"],a;return{init:o,refresh:i}}();$(document).ready(function(){$(".dropdown").each(function(){$(this).parent().eq(0).hover(function(){$(this).find("a").addClass("current");$(".dropdown:eq(0)",this).show()},function(){$(this).find("a").removeClass("current");$(".dropdown:eq(0)",this).hide()})});Placeholders.init()});