listenSubmit("#myForm",(function(e){e.preventDefault(),$.ajax({url:route("contact.store"),type:"POST",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#myForm")[0].reset())},error:function(e){var t,s,r;t="#contactError",s=e.responseJSON.message,(r=$(t)).removeClass("d-none"),r.show(),r.text(s),setTimeout((function(){$(t).slideUp()}),3e3)}})})),listenClick(".contact-enquiry-delete-btn",(function(e){var t=$(e.currentTarget).attr("data-id");deleteItem(route("contactus.destroy",t),"Enquiry")}));