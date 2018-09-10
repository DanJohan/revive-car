function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
 } 

$(document).on('keypress','.validateNumeric',function(e){
   return isNumber(e,$(this));
})
$(function(){
	var maxField = 10; 
	var wrapper = $('.labour-table'); 
	var x = invoiceConfig.labourFieldStart; 


        //Once add button is clicked
    $(document).on('click','.labour-add-button',function(e){
    	e.preventDefault();
        if(x < maxField){ 
			var fieldHTML = '<tr>'+
	                  '<td><input type="text" class="form-control labour-item invoice-item" name="labour['+x+'][item]"  /></td>'+
	                  '<td><input type="text" class="form-control labour-hour validateNumeric" name="labour['+x+'][hour]" /></td>'+
	                  '<td><input type="text" class="form-control labour-rate validateNumeric" name="labour['+x+'][rate]" /></td>'+
	                  '<td><input type="text" class="form-control labour-cost" readonly name="labour['+x+'][cost]" /></td>'+
	                  '<td><input type="text" class="form-control labour-gst validateNumeric" name="labour['+x+'][gst]" value="0.00" /><input type="hidden"'+
	                  'class="gst-amount" value="0.00" name="labour['+x+'][gst_amount]"></td>'+
	                  '<td><input type="text" readonly class="form-control labour-total validateNumeric" name="labour['+x+'][total]" /></td>'+
	                  '<td><button class="btn btn-success labour-delete-button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
	              '</tr>'; //New input field html
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

     //Once remove button is clicked
    $(document).on('click', '.labour-delete-button', function(e){
        e.preventDefault();
        $(this).parents('tr').find('.labour-hour').val(0.00);
        $(this).parents('tr').find('.labour-hour').trigger('keyup');
        $(this).parents('tr').remove(); //Remove field html
        x--; //Decrement field counter
    });
});  // function for labour table add field dynamically

$(function(){
	var maxField = 10; //Input fields increment limitation
	var wrapper = $('.parts-table'); //table wrapper
	var x = invoiceConfig.partsFieldStart; //Initial field counter is 1
 //New input field html

        //Once add button is clicked
    $(document).on('click','.parts-add-button',function(e){
    	console.log('here',x);
    	e.preventDefault();
        //Check maximum number of input fields
        if(x < maxField){ 
    		var fieldHTML = '<tr>'+
                      '<td><input type="text" class="form-control parts-item" name="parts['+x+'][item]" /></td>'+
                      '<td><input type="text" class="form-control parts-qty validateNumeric" name="parts['+x+'][qty]" /></td>'+
                      '<td><input type="text" class="form-control parts-cost validateNumeric" name="parts['+x+'][cost]" /></td>'+
                      '<td><input type="text" class="form-control parts-gst validateNumeric" name="parts['+x+'][gst]" value="0.00" /><input type="hidden"'+
                      'class="gst-amount" name="parts['+x+'][gst_amount]" value="0.00"></td>'+
                      '<td><input type="text" readonly class="form-control parts-total" name="parts['+x+'][total]" /></td>'+
                      '<td><button class="btn btn-success parts-delete-button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
                  '</tr>';
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

     //Once remove button is clicked
    $(document).on('click', '.parts-delete-button', function(e){
        e.preventDefault();
        $(this).parents('tr').find('.parts-qty').val(0.00);
        $(this).parents('tr').find('.parts-qty').trigger('keyup');
        $(this).parents('tr').remove(); //Remove field html
        x--; //Decrement field counter

      $('.parts-qty:first').trigger('keyup');
    });
});  // function for parts table add field dynamically

$(function(){
	var labourTotal=[];
	var labourTotalSum=invoiceConfig.labourTotalSum;
	var partsTotal=[];
	var partsTotalSum=invoiceConfig.partsTotalSum;
	var gstTotal=[];
	var gstTotalSum=invoiceConfig.gstTotalSum;
	var totalAmount=invoiceConfig.totalAmount;

	function getLabourTotal(){
		labourTotalSum=0.00;
		$('.labour-table').find('.labour-cost').each(function(index,el){
			labourTotal[index]=($(this).val())?$(this).val():0.00;
		});
		for (var i = 0;i<labourTotal.length; i++) {
			labourTotalSum += parseFloat(labourTotal[i]);
		}
		labourTotalSum = labourTotalSum.toFixed(2);
		//console.log(labourTotalSum);
		$("#total-labour-amount").html('&#x20b9; '+labourTotalSum);
		$('input[name="labour_total"]').val(labourTotalSum);
		totalAmount = parseFloat(labourTotalSum)+parseFloat(partsTotalSum)+parseFloat(gstTotalSum);
		$("#total-amount").html('&#x20b9; '+totalAmount.toFixed(2));
	}

	function getPartsTotal(){
		partsTotalSum=0.00;
		var partsQtyFields=$('.parts-table').find('.parts-qty');
		$('.parts-table').find('.parts-cost').each(function(index,el){
			var partsCost=($(this).val())?$(this).val():0.00;
			var partsQty=partsQtyFields[index].value;
			//console.log(partsQty.value);
			partsTotal[index]=(parseFloat(partsQty)*parseFloat(partsCost)).toFixed(2);
			//partsTotal[index]=($(this).val())?$(this).val():0.00;
		});
		for (var i = 0;i<partsTotal.length; i++) {
			partsTotalSum += parseFloat(partsTotal[i]);
		}

		partsTotalSum = partsTotalSum.toFixed(2);

		$("#total-parts-amount").html('&#x20b9; '+partsTotalSum);
		$('input[name="parts_total"]').val(partsTotalSum);

		totalAmount = parseFloat(labourTotalSum)+parseFloat(partsTotalSum)+parseFloat(gstTotalSum);

		$("#total-amount").html('&#x20b9; '+totalAmount.toFixed(2));
	}

	function getGstTotal(){
		gstTotalSum=0.00;
		$('.labour-table,.parts-table').find('.gst-amount').each(function(index,el){
			gstTotal[index]=($(this).val())?$(this).val():0.00;
		});
		console.log(gstTotal);
		for (var i = 0;i<gstTotal.length; i++) {
			gstTotalSum += parseFloat(gstTotal[i]);
		}
		$("#total-gst-amount").html('&#x20b9; '+gstTotalSum.toFixed(2));
		$('input[name="gst_total"]').val(gstTotalSum.toFixed(2));
		totalAmount = parseFloat(labourTotalSum)+parseFloat(partsTotalSum)+parseFloat(gstTotalSum);
		$("#total-amount").html('&#x20b9; '+totalAmount.toFixed(2));
	}
	$(document).on('keyup','.labour-hour',function(e){
		//e.stopPropagation();
		var rateField = $(this).parents('tr').find('.labour-rate');
		var gstAmountField = $(this).parents('tr').find('.gst-amount');
		var rate=(rateField.val())?rateField.val():0.00;
		var totalField = $(this).parents('tr').find('.labour-total');
		var costField = $(this).parents('tr').find('.labour-cost');
		var gstField = $(this).parents('tr').find('.labour-gst');
		var gst =(gstField.val())?gstField.val():0.00;
		var hour = $(this).val();
		costField.val((hour*rate).toFixed(2));
		cost=(costField.val())?costField.val():0.00;
		gstAmountField.val((cost/100*gst).toFixed(2));
		gstAmount=gstAmountField.val();
		totalField.val((Number(cost)+Number((cost/100*gst))).toFixed(2));
		getLabourTotal();
		getGstTotal();
		calculateDiscount($('#discount'));
	});

	$(document).on('keyup','.labour-rate',function(){
		var totalField = $(this).parents('tr').find('.labour-total');
		var gstAmountField = $(this).parents('tr').find('.gst-amount');
		var hourField = $(this).parents('tr').find('.labour-hour');
		var hour = (hourField.val())?hourField.val():0.00;
		var costField = $(this).parents('tr').find('.labour-cost');
		var gstField = $(this).parents('tr').find('.labour-gst');
		var gst= (gstField.val())?gstField.val():0.00;
		var rate = $(this).val();
		costField.val((hour*rate).toFixed(2));
		cost=(costField.val())?costField.val():0.00;
		gstAmountField.val((cost/100*gst).toFixed(2));
		gstAmount=gstAmountField.val();
		totalField.val((Number(cost)+Number(gstAmount)).toFixed(2));
		getLabourTotal();
		getGstTotal();
		calculateDiscount($('#discount'));
	});

	$(document).on('keyup','.labour-gst',function(){
		var totalField = $(this).parents('tr').find('.labour-total');
		var gstAmountField = $(this).parents('tr').find('.gst-amount');
		var costField = $(this).parents('tr').find('.labour-cost');
		var cost=(costField.val())?costField.val():0.00;
		var gst = $(this).val();
		gstAmountField.val((cost/100*gst).toFixed(2));
		gstAmount=gstAmountField.val();
		totalField.val((Number(cost)+Number(gstAmount)).toFixed(2));
		getLabourTotal();
		getGstTotal();
		calculateDiscount($('#discount'));
	});

	$(document).on('keyup','.parts-qty',function(){
		var totalField = $(this).parents('tr').find('.parts-total');
		var gstAmountField = $(this).parents('tr').find('.gst-amount');
		var costField = $(this).parents('tr').find('.parts-cost');
		var gstField = $(this).parents('tr').find('.parts-gst');
		var cost=(costField.val())?costField.val():0.00;
		var gst = (gstField.val())?gstField.val():0.00;
		var qty = $(this).val();
		var amount = cost*qty;
		gstAmountField.val((amount/100*gst).toFixed(2));
		gstAmount=gstAmountField.val();
		//console.log(gstAmount);
		totalField.val((Number(amount)+Number(gstAmount)).toFixed(2));
		getPartsTotal();
		getGstTotal();
		calculateDiscount($('#discount'));
	});

	$(document).on('keyup','.parts-cost',function(){
		var qtyField = $(this).parents('tr').find('.parts-qty');
		var gstAmountField = $(this).parents('tr').find('.gst-amount');
		var totalField = $(this).parents('tr').find('.parts-total');
		var gstField = $(this).parents('tr').find('.parts-gst');
		var gst = (gstField.val())?gstField.val():0.00;
		var qty=(qtyField.val())?qtyField.val():0.00;
		var cost = $(this).val();
		var amount = cost*qty;
		gstAmountField.val((amount/100*gst).toFixed(2));
		gstAmount=gstAmountField.val();
		totalField.val((Number(amount)+Number(gstAmount)).toFixed(2));
		getPartsTotal();
		getGstTotal();
		calculateDiscount($('#discount'));
	});

	$(document).on('keyup','.parts-gst',function(){
		var qtyField = $(this).parents('tr').find('.parts-qty');
		var gstAmountField = $(this).parents('tr').find('.gst-amount');
		var totalField = $(this).parents('tr').find('.parts-total');
		var costField = $(this).parents('tr').find('.parts-cost');
		var cost=(costField.val())?costField.val():0.00;
		var gst = $(this).val();
		var qty=(qtyField.val())?qtyField.val():0.00;
		var amount = cost*qty;
		gstAmountField.val((amount/100*gst).toFixed(2));
		gstAmount=gstAmountField.val();
		totalField.val((Number(amount)+Number(gstAmount)).toFixed(2));
		getPartsTotal();
		getGstTotal();
		calculateDiscount($('#discount'));
	});
	function calculateDiscount(el){
		var discount=el.val()/100;
		tempTotalAmount=totalAmount;
		var discountAmount = tempTotalAmount*discount;
		$('#discountAmount').val(discountAmount.toFixed(2));
		tempTotalAmount=(tempTotalAmount-discountAmount).toFixed(2);
		$("#total-amount").html('&#x20b9; '+tempTotalAmount);
		$('#totalAmountAfterDiscount').val(tempTotalAmount);
		$('#totalAmount').val(parseFloat(totalAmount).toFixed(2));
	}
	$(document).on('keyup','#discount',function(){
		calculateDiscount($(this));
	});
});

$(document).on('submit','#invoice-form',function(e){
	if($('#totalAmountAfterDiscount').val()=="0.00"){
		alert("Your total amount is zero! Please create amount.");
		return false;
	}
	return true;
});