<script>
    let deletedItems=[],token=$('meta[name="csrf-token"]').attr("content"),list_target="#list-target",list_target_route="{{route($list_target_route)}}";function dissableForm(t,o,i=!1){t.find("input, textarea, select").each(function(){var t=$(this).attr("name"),e=$(this).attr("type"),n=$(this).attr("data-ignore");"_token"===t||"_method"===t||null!=n||"hidden"==e?$(this).prop("disabled",!1):(i&&$(this).val(""),$(this).prop("disabled",o)),"checkbox"!==e&&"radio"!==e||$(this).prop("disabled",o)})}function EditItem(t,o){$.ajax({type:"GET",url:t,timeout:6e4,datatype:"json",cache:!1,beforeSend:function(t){$(o).html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>')},error:function(t,e,n){$(o).html("")},success:function(t){$(o).html(""),$(o).html(t);const e=$(o).find("form");e.find(".new_btn").hide(),e.find(".cancel_btn").show(),e.find(".save_btn").prop("disabled",!1),$(o).find(".dropify").each(function(){$(this).dropify()}),$(o).find(".summernote").each(function(){$(this).summernote("disable")})}})}function ListItems(t,o){$.ajax({type:"GET",url:t,data:{type:"list"},timeout:6e4,datatype:"json",cache:!1,beforeSend:function(t){$(o).html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>')},error:function(t,e,n){$(o).html("")},success:function(t){$(o).html(t.data)}})}function DeleteItem(t,e){Swal.fire({title:"Are you sure?",text:"This is an irrevisable action that will delete "+t.toUpperCase()+" Are you sure you want to delete "+t.toUpperCase(),icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(t=>{t.isConfirmed&&$.ajax({type:"DELETE",url:e,data:{_token:token},timeout:6e4,datatype:"json",cache:!1,error:function(t,e,n){$(this).prop("disabled",!1),$(".spin-loader").fadeOut();var o=xhr.responseJSON.errors,o=Object.values(o)[0];Swal.fire({title:o,icon:"error",confirmButtonText:"Close"})},success:function(t){$(".success-response").html(t.message),Swal.fire({title:t.message,icon:t.status,confirmButtonText:"Close"}),t.list_target&&t.list_target_route&&ListItems(t.list_target_route,t.list_target),t.Reload&&setTimeout(function(){window.location.reload()},2e3)}})})}function SaveItem(){let t=$(this).closest("form");var e=new FormData(t[0]),n=t.attr("action"),o=t.attr("method");$.ajax({type:o,url:n,data:e,cache:!1,contentType:!1,processData:!1,error:function(t,e,n){$(this).prop("disabled",!1),$(".spin-loader").fadeOut();t=t.responseJSON.errors,t=Object.values(t)[0];Swal.fire({title:t,icon:"error",confirmButtonText:"Close"})},success:function(t){Swal.fire({title:html_to_text(t.message),icon:t.status,confirmButtonText:"Close"}),t.Reload&&setTimeout(function(){window.location.reload()},2e3)}})}$(function(){"use strict";ListItems(list_target_route,list_target)}),$("#mini-search").on("keyup",function(){var t=$(this).val().toLowerCase();$("#amicrudTable tbody tr").filter(function(){$(this).toggle(-1<$(this).text().toLowerCase().indexOf(t))})}),$(document).ready(function(){$(document).on("click",".cancel_btn",function(t){let e=$(this).closest("form");dissableForm(e,!1,!0),e.find("input, textarea, select, .delete_btn, .save_btn").each(function(){$(this).prop("disabled",!0)}),$('form input[name="_token"]').prop("disabled",!1),e.find(".new_btn").show(),e.find(".new_btn").prop("disabled",!1),e.find(".summernote").each(function(){$(this).summernote("disable")}),$(this).hide()}),$(document).on("click",".new_btn",function(t){let e=$(this).closest("form");e.find(".delete_btn").prop("disabled",!0),e.find(".cancel_btn").show(),e.find(".edit_btn").hide(),e.find(".cancel_btn, .save_btn").each(function(){$(this).prop("disabled",!1)}),dissableForm(e,!1,!0),e.find('input[name="id"]').val(null),$(this).hide()}),$(document).on("click",".edit_btn",function(t){let e=$(this).closest("form");e.find(".save_btn").each(function(){$(this).prop("disabled",!1)}),e.find(".new_btn").hide(),e.find(".cancel_btn").show(),e.find(".cancel_btn").prop("disabled",!1),$(this).hide(),dissableForm(e,!1)}),$(document).on("click",".edit-item-btn",function(){EditItem($(this).attr("data-url"),"#form-target")}),$(document).on("click",".remove-item-btn",function(){var t=$(this).attr("data-url");DeleteItem($(this).attr("data-name"),t)}),$(document).on("click",".save_btn",function(t){t.preventDefault();const i=$(this);i.prop("disabled",!0);let e=i.closest("form");var n=new FormData(e[0]),o=e.attr("action"),s=e.attr("method");Swal.fire({title:"Are you sure?",text:"Do want to save this record?",icon:"question",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, save it!",cancelButtonText:"No, cancel!"}).then(t=>{t.isConfirmed&&(i.append('<span class="spin-loader"> <i class="fa fa-spinner fa-spin"></i> please wait...</span>'),$.ajax({type:s,url:o,data:n,cache:!1,contentType:!1,processData:!1,error:function(t,e,n){i.prop("disabled",!1),$(".spin-loader").fadeOut();var o=t.responseJSON.errors;if(o){for(control in o)$(".error-response."+control).html("<code>"+o[control][0]+"</code>");setTimeout(function(){$(".error-response").html("")},3e3)}else{t=Object.values(o)[0];Swal.fire({title:t,icon:"error",confirmButtonText:"Close"})}},success:function(t){i.prop("disabled",!1),$(".spin-loader").fadeOut(),Swal.fire({title:t.message,icon:t.status,confirmButtonText:"Close"}),t.list_target&&t.list_target_route&&(ListItems(t.list_target_route,t.list_target),i.parent().find(".cancel_btn").click()),t.reload&&setTimeout(function(){window.location.reload()},2e3)}})),i.prop("disabled",!1)})})}),document.addEventListener("DOMContentLoaded",function(){var e=document.getElementById("exportGroup"),n=e.querySelector(".dropdown-menu");e.querySelector(".dropdown-toggle").addEventListener("click",function(){n.classList.toggle("show")}),document.addEventListener("click",function(t){e.contains(t.target)||n.classList.remove("show")})});
</script>