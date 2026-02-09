 $(document).ready(function(){
    $(document).on('click', '.collapse-action .collapse-row', function(){
        $(this).addClass('hidden-act');
        $(this).parents('.collapse-action').find('.open-row').removeClass('hidden-act');
        $(this).parents('.row').find('.hide-on-click').addClass('hidden');
        $(this).parents('.row').find('.sub-total-row').addClass(' position');    
     });

     $(document).on('click', '.collapse-action .open-row', function () {
         $(this).addClass('hidden-act');
         $(this).parents('.collapse-action').find('.collapse-row').removeClass('hidden-act');
         $(this).parents('.row').find('.hide-on-click').removeClass('hidden');
         $(this).parents('.row').find('.sub-total-row').removeClass(' position'); 
     });
	
	$(document).on('click', '.edit-del-act .edit-act', function(){
		var top_pos = $(this).parents('.col-md-12').offset().top;
		var left_pos = $(this).parents('.col-md-12').offset().left;
		var width = $(this).parents('.col-md-12').outerWidth();
		
		$('body').append('<div class="edit-overlay">'+ $(this).parents('.col-md-12')[0].outerHTML +'<button class="btn btn-success btn-fill" style="color: #fff;background-color: #35a934;padding: 8px 35px;position: absolute;bottom: 30px;right: 30px;">Save</button></div>');
		
		$('.edit-overlay .col-md-12').css({
			top: top_pos,
			left: left_pos,
			width: width,
			margin: '0px',
		});
		
		$('.edit-overlay .col-md-12 .edit-del-act').remove();
		
		$('.edit-overlay').find('select, input').removeAttr('disabled', 'disabled');
     });

     $(document).on('click', '.delete-fabrication', function () {
         //$(this).parents('.fabri-container').find('.quote-card').css('display', 'none');
         $(this).parents('.fabri-container').remove();
     });
	
	$(document).on('click', '.edit-del-act .delete-act', function(){
		$(this).parents('.col-md-12').fadeOut(500, function(){
			$(this).remove();
		});
	});
	
	$(document).on('click', '.edit-overlay button', function(){
		$('.edit-overlay').fadeOut(500, function(){
			$(this).remove();
		});
	});
	
//	$('#addItem').click(function(){
//        $('.items--list').append(`<div class="card quote-card">
//	<div class="row">
//		<div class="col-md-12">
//			<div class="col-md-4">
//				<div class="upper-input">
//				<label class="pt-10" style="width: 200px;">Fabrication</label>
//				<input type="text" class="form-control" placeholder="Enter Fabrication" />
//				</div>
//			</div>
			
//			<div class="col-md-3">
//				<div class="upper-input">
//				<label class="pt-10" style="width: 120px;">Quantity </label>
//				<input type="text" class="form-control" placeholder="" />
//				</div>
//			</div>
			
//			<div class="col-md-5 pull-right item-total">
//				<div class="col-md-4 text-center">
//					<div class="top-amount">
//						<span class="curr-symbol">Â£ </span><span class="amount">0.00</span>
//						<p class="text-center upper-amount-lbl">budget</p>
//					</div>
//				</div>	                			
//				<div class="col-md-4 text-center">
//					<div class="top-amount">
//						<span class="curr-symbol">Â£ </span><span class="amount">0.00</span>
//						<p class="text-center upper-amount-lbl">retail</p>
//					</div>
//				</div>
//				<div class="col-md-4 text-center">
//					<div class="top-amount">
//						<span class="curr-symbol">Â£ </span><span class="amount">0.00</span>
//						<p class="text-center upper-amount-lbl">contribution</p>
//					</div>
//				</div>

//			</div>
			
//		</div>
//	</div>
	
	
//	<div class="row m-0">
//		<div class="col-md-12 grid-header mt-20 mb-20">
//			<div class="col-md-3 text-center">
//				<label class="quan-label">Select Item</label>
//			</div>
//			<div class="col-md-2 text-center">
//				<label class="quan-label">Quantity</label>
//			</div>
//			<div class="col-md-2 text-center">
//				<label class="quan-label">Budget</label>
//			</div>
//			<div class="col-md-2 text-center">
//				<label class="quan-label">Retail</label>
//			</div>
//			<div class="col-md-2 text-center">
//				<label class="quan-label">Contribution</label>
//			</div>
//		</div>
//	</div>
//	 <div class="row material-row">
//		<div class="col-md-12 mt-20 mb-20">
//			<div class="col-md-2 min-h40">
//				<label class="pt-10">Materials</label>
//			</div>
//			<div class="col-md-2">
//				<a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Materials<span class="ml-10 ti-plus"></span></a>
//			</div>
//			<div class="col-md-1 zindex-999 min-h40 pull-right text-right">	                			
//				<div class="collapse-action material-action">
//					<a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
//					<a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
//				</div>
//			</div>	                		
//		</div>
//		<div class="hide-on-click">
//		</div>
//	</div>
//	<hr>
//	<div class="row labour-row">
//		<div class="col-md-12 mt-20 mb-20">
//			<div class="col-md-2">
//				<label class="quan-label">Labour</label>
//			</div>
//			<div class="col-md-2">
//				<a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Labour<span class="ml-10 ti-plus"></span></a>
//			</div>
//			<div class="col-md-1 zindex-999 min-h40 pull-right text-right">
//				<div class="collapse-action labour-action">
//					<a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
//					<a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
//				</div>
//			</div>	                		
//		</div>

//		<div class="hide-on-click">
//		</div>
//	</div>

//  <hr>

//  <div class="row thirdparty-row">
//		<div class="col-md-12 mt-20 mb-20">
//			<div class="col-md-2">
//				<label class="quan-label">Third Party</label>
//			</div>
//			<div class="col-md-2">
//				<a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Third Party<span class="ml-10 ti-plus"></span></a>
//			</div>
//			<div class="col-md-1 zindex-999 min-h40 pull-right text-right">
//				<div class="collapse-action thirdparty-action">
//					<a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
//					<a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
//				</div>
//			</div>	                		
//		</div>
//		<div class="hide-on-click">
//		</div>
//	</div>


//  <hr>


//<div class="row accomodation-row">
//		<div class="col-md-12 mt-20 mb-20">
//			<div class="col-md-2">
//				<label class="quan-label">Third Party</label>
//			</div>
//			<div class="col-md-2">
//				<a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Accomodation<span class="ml-10 ti-plus"></span></a>
//			</div>
//			<div class="col-md-1 zindex-999 min-h40 pull-right text-right">
//				<div class="collapse-action thirdparty-action">
//					<a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
//					<a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
//				</div>
//			</div>	                		
//		</div>
//<div class="hide-on-click">
//		</div>
//	</div>
//</div>`);


	
//	$('.main-panel').animate({
//		scrollTop: $('.items--list .card:last-child').offset().top,
//	}, 500);
	
//	});


     //$(document).on('click', '.overall-action a', function () {
     //    $('.items--list').append(`<div class="items--list second-items--list">

     //       <div class="card quote-card">

     //           <div class="row">
     //               <div class="col-md-12">
     //                   <div class="col-md-3">
     //                       <div class="upper-input">
     //                           <label class="pt-10" style="width: 200px;">Fabrication</label>
     //                           <input type="text" class="form-control" placeholder="Enter Fabrication">
     //                       </div>
     //                   </div>

     //                   <div class="col-md-3">
     //                       <div class="upper-input">
     //                           <label class="pt-10" style="width: 120px;">Quantity </label>
     //                           <input type="text" class="form-control" placeholder="">
     //                       </div>
     //                   </div>

     //                   <div class="col-md-5 item-total">
     //                       <div class="col-md-4 text-center">
     //                           <div class="top-amount">
     //                               <span class="curr-symbol">Â£ </span><span class="amount">0.00</span>
     //                               <p class="text-center upper-amount-lbl">budget</p>
     //                           </div>
     //                       </div>
     //                       <div class="col-md-4 text-center">
     //                           <div class="top-amount">
     //                               <span class="curr-symbol">Â£ </span><span class="amount">0.00</span>
     //                               <p class="text-center upper-amount-lbl">retail</p>
     //                           </div>
     //                       </div>
     //                       <div class="col-md-4 text-center">
     //                           <div class="top-amount">
     //                               <span class="curr-symbol">Â£ </span><span class="amount">0.00</span>
     //                               <p class="text-center upper-amount-lbl">contribution</p>
     //                           </div>
     //                       </div>

     //                   </div>
     //                   <div class="col-md-1 zindex-999 min-h40 pull-right text-right">
     //                       <div class="overall-action">
     //                           <a class="pull-right open-row" href="javascript:void(0)"><span class="ti-layers"></span></a>
     //                       </div>
     //                   </div>
     //               </div>
     //           </div>


     //           <div class="row m-0">
     //               <div class="col-md-12 grid-header mt-20 mb-20">
     //                   <div class="col-md-3 text-center">
     //                       <label class="quan-label">Select Item</label>
     //                   </div>
     //                   <div class="col-md-2 text-center">
     //                       <label class="quan-label">Quantity</label>
     //                   </div>
     //                   <div class="col-md-2 text-center">
     //                       <label class="quan-label">Budget</label>
     //                   </div>
     //                   <div class="col-md-2 text-center">
     //                       <label class="quan-label">Retail</label>
     //                   </div>
     //                   <div class="col-md-2 text-center">
     //                       <label class="quan-label">Contribution</label>
     //                   </div>
     //               </div>
     //           </div>
     //           <div class="row material-row">
     //               <div class="col-md-12 mt-20 mb-20">
     //                   <div class="col-md-2 min-h40">
     //                       <label class="pt-10">Materials</label>
     //                   </div>
     //                   <div class="col-md-2">
     //                       <a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Materials<span class="ml-10 ti-plus"></span></a>
     //                   </div>
     //                   <div class="col-md-1 zindex-999 min-h40 pull-right text-right">
     //                       <div class="collapse-action material-action">
     //                           <a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
     //                           <a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
     //                       </div>
     //                   </div>
     //               </div>
     //               <div class="hide-on-click">
     //                   <div class="col-md-12 mt-20 mb-20">
     //                       <div class="col-md-3">
     //                           <select class="form-control b1">
     //                               <option value="01">-- Select --</option>
     //                               <option value="03">Material 1</option>
     //                               <option value="01">Material 2</option>
     //                           </select>
     //                       </div>
     //                       <div class="col-md-2">
     //                           <input type="text" class="form-control text-center" name="" placeholder="Enter Quantity">
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-1 min-h40">
     //                           <div class="edit-del-act">
     //                               <a class="delete-act" href="javascript:void(0)">
     //                                   <span class="ti-trash"></span>
     //                               </a>
     //                           </div>
     //                       </div>
     //                   </div>
     //               </div>
     //           </div>
     //           <hr>
     //           <div class="row labour-row">
     //               <div class="col-md-12 mt-20 mb-20">
     //                   <div class="col-md-2">
     //                       <label class="quan-label">Labour</label>
     //                   </div>
     //                   <div class="col-md-2">
     //                       <a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Labour<span class="ml-10 ti-plus"></span></a>
     //                   </div>
     //                   <div class="col-md-1 zindex-999 min-h40 pull-right text-right">
     //                       <div class="collapse-action labour-action">
     //                           <a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
     //                           <a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
     //                       </div>
     //                   </div>
     //               </div>

     //               <div class="hide-on-click">
     //                   <div class="col-md-12 mt-20 mb-20">
     //                       <div class="col-md-2">
     //                           <select class="form-control b1">
     //                               <option value="01">-- Select --</option>
     //                               <option value="01">Basic - Sanding / Priming (Â£15  p/h)</option>
     //                               <option value="02">General - Casting / Spraying / Joinery / Metal (Â£18  p/h)</option>
     //                               <option value="03">Specialist - Mould / Sculpture / Scenic (Â£20 p/h) </option>
     //                           </select>
     //                       </div>
     //                           <div class="col-md-2">
     //                           <select class="form-control b1">
     //                               <option value="01">-- Select --</option>
     //                               <option value="01">Basic - Sanding / Priming (Â£15  p/h)</option>
     //                               <option value="02">General - Casting / Spraying / Joinery / Metal (Â£18  p/h)</option>
     //                               <option value="03">Specialist - Mould / Sculpture / Scenic (Â£20 p/h) </option>
     //                           </select>
     //                       </div>
     //                       <div class="col-md-1">
     //                           <input type="text" class="form-control text-center" name="" placeholder="01">
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-1 min-h40">
     //                           <div class="edit-del-act">
     //                               <a class="delete-act" href="javascript:void(0)">
     //                                   <span class="ti-trash"></span>
     //                               </a>
     //                           </div>
     //                       </div>
     //                   </div>
     //               </div>
     //           </div>

     //           <hr>

     //           <div class="row thirdparty-row">
     //               <div class="col-md-12 mt-20 mb-20">
     //                   <div class="col-md-2">
     //                       <label class="quan-label">Third Party</label>
     //                   </div>
     //                   <div class="col-md-2">
     //                       <a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Third Party<span class="ml-10 ti-plus"></span></a>
     //                   </div>
     //                   <div class="col-md-1 zindex-999 min-h40 pull-right text-right">
     //                       <div class="collapse-action thirdparty-action">
     //                           <a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
     //                           <a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
     //                       </div>
     //                   </div>
     //               </div>

     //               <div class="hide-on-click">
     //                   <div class="col-md-12 mt-20 mb-20">
     //                       <div class="col-md-3">
     //                           <select class="form-control b1">
     //                               <option value="01">-- Select --</option>
     //                               <option value="01">Third Party 1</option>
     //                               <option value="02">Third Party 2</option>
     //                           </select>
     //                       </div>
     //                       <div class="col-md-2">
     //                           <input type="text" class="form-control text-center" name="" placeholder="Enter Quantity">
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-1 min-h40">
     //                           <div class="edit-del-act">
     //                               <a class="delete-act" href="javascript:void(0)">
     //                                   <span class="ti-trash"></span>
     //                               </a>
     //                           </div>
     //                       </div>
     //                   </div>
     //               </div>
     //           </div>

     //           <hr>

     //           <div class="row accomodation-row">
     //               <div class="col-md-12 mt-20 mb-20">
     //                   <div class="col-md-2">
     //                       <label class="quan-label">Project Accomodation</label>
     //                   </div>
     //                   <div class="col-md-2">
     //                       <a class="btn btn-info btn-fill btn-wd btn-custom-grid zindex-999 bg-color" href="javascript:void(0)">Add Accomodation<span class="ml-10 ti-plus"></span></a>
     //                   </div>
     //                   <div class="col-md-1 zindex-999 min-h40 pull-right text-right">
     //                       <div class="collapse-action thirdparty-action">
     //                           <a class="pull-right collapse-row" href="javascript:void(0)"><span class="ti-minus"></span></a>
     //                           <a class="pull-right open-row hidden-act" href="javascript:void(0)"><span class="ti-plus"></span></a>
     //                       </div>
     //                   </div>
     //               </div>

     //               <div class="hide-on-click">
     //                   <div class="col-md-12 mt-20 mb-20">
     //                       <div class="col-md-3">
     //                           <select class="form-control b1">
     //                               <option value="01">-- Select --</option>
     //                               <option value="01">Accomodation 1</option>
     //                               <option value="02">Accomodation 2</option>
     //                           </select>
     //                       </div>
     //                       <div class="col-md-2">
     //                           <input type="text" class="form-control text-center" name="" placeholder="Enter Quantity">
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-2" style="text-align: center;font-size: 16px;padding-top: 8px;">
     //                           <label>Â£ 0.00</label>
     //                       </div>
     //                       <div class="col-md-1 min-h40">
     //                           <div class="edit-del-act">
     //                               <a class="delete-act" href="javascript:void(0)">
     //                                   <span class="ti-trash"></span>
     //                               </a>
     //                           </div>
     //                       </div>
     //                   </div>
     //               </div>
     //           </div>

     //       </div>

     //   </div>`);
     //    $('.main-panel').animate({
     //        scrollTop: $('.items--list .card:last-child').offset().top,
     //    }, 500);
     //});
	
     $(function () {
         var current = location.pathname + location.search;
         //console.log(current);
         $('.sidebar-wrapper .nav li a').each(function () {
             var $this = $(this);
             // if the current path is like this link, make it active
             if ($this.attr('href') === current) {
                 $this.addClass('active');
             }
         });
     });


     $(".clone-quot-row").click(function () {
         $('tbody').append(`<tr class="cloned">
                                        <td>123</td>
                                        <td>07-05-2019</td>
                                        <td>ABC Limited</td>
                                        <td>Alphabet Project</td>
                                        <td>Craig</td>
                                        <td>1000</td>
                                        <td>2000</td>
                                        <td>1000</td>
                                        <td>
                                            <a class="customhover archive-link" href="javascript:void(0)" data-toggle="modal" data-target="#archive-popup">
                                                <span title="Archive" class="ti-archive archive-blue"></span>
                                            </a>
                                            <a class="customhover unarchive-link" href="javascript:void(0)">
                                                <span title="Unarchive" class="ti-archive archive-red"></span>
                                            </a>

                                            &nbsp;
                                            <a title="Edit" href="javascript:void(0)" data-toggle="modal" data-target="#editQuotation"><span class="ti-pencil-alt2"></span></a>&nbsp;
                                            <a title="Delete" class="customhover"><span class="ti-trash"></span></a>&nbsp;&nbsp;
                                            <a title="View" href="line-item.html"><span class="ti-book"></span></a>&nbsp;&nbsp;
                                            <a title="Clone" class="clone-quot-row" href="javascript:void(0)"><span class="ti-layers-alt 1"></span></a>
                                        </td>
                                        <td><input style="width: 15px; margin-left: auto; margin-right: auto;" type="checkbox" checked="" class="form-control"></td>
                                    </tr>`);
     });
     

     // $(".archive-link").click(function () {
     //     // $("#FilterRow").animate({
     //     //     height: 'toggle'
     //     // });
     //     $(this).toggleClass("archived");
     // });

       $(".archive-ok").click(function () {
         $('.archive-link').addClass("archived");         
         $('.unarchive-link').addClass("archived");
     });

       $(".unarchive-link").click(function () {
         $(this).removeClass("archived");         
         $('.archive-link').removeClass("archived");
         $('.unarchive-link').removeClass("archived");
     });

     

     $('.sidebar-wrapper').animate({
         scrollTop: $('.sidebar-wrapper .nav li.active').offset().top
     });
     

     $(".collapser").click(function () {
         $("#FilterRow").animate({
             height: 'toggle'
         });
         $(this).toggleClass("collapsed");
     });
 });

