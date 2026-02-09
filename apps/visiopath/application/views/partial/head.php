     <!-- Bootstrap core CSS     --> 
    <link  href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" async />

    <!--  Paper Dashboard core CSS    -->
    <link href="<?php echo base_url();?>assets/css/paper-dashboard.css?a" rel="stylesheet" async />


 <?php /*?>   <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url();?>assets/css/demo.css" rel="stylesheet" />
<?php */?>

    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" async>
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css' async>
    <link href="<?php echo base_url();?>assets/css/themify-icons.css" rel="stylesheet" async>

    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/colorbox.css" async />
    <link href="<?php echo base_url();?>assets/css/custom.css?131" rel="stylesheet" async>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    
     

    <script>
            $(document).ready(function(){
                //Examples of how to assign the Colorbox event to elements
            
                $(".ajax").colorbox();
                $("a[rel='example3']").colorbox({transition:"none", width:"75%", height:"75%"});
                $(".callbacks").colorbox({

                    onOpen:function(){ alert('onOpen: colorbox is about to open'); },
                    onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
                    onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
                    onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
                    onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
                });

                $('.non-retina').colorbox({rel:'group5', transition:'none'})
                $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
                
                //Example of preserving a JavaScript event for inline calls.
                $("#click").click(function(){ 
                    $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                    return false;
                });
            });

         
        </script>

        <script type="text/javascript">
            <!--
         /*   function silentErrorHandler() {return true;}
            window.onerror=silentErrorHandler;
            window.onwarn=silentErrorHandler;
            *///-->
        </script>


    <script type="text/javascript">

function print1(strid)
{
if(confirm("Do you want to print?"))
{
    var html="<html>";
    html+="<head>";
   
    html+="<link rel='Stylesheet' type='text/css' href='<?php echo base_url();?>assets/css/custom.css' media='print' />";
    html+="</head>";
    html+="</html>";
var values = document.getElementById(strid);
var printing =
window.open('','','left=0,top=0,width=550,height=400,toolbar=0,scrollbars=0,sta­?tus=0');
printing.document.write(values.innerHTML);
printing.document.close();
printing.focus();
printing.print();
printing.close();
}
}

/*
var scrollable = document.querySelector('#bootstrap-table2');

scrollable.addEventListener('wheel', function(event) {
    var deltaY = event.deltaY;
    var contentHeight = scrollable.scrollHeight;
    var visibleHeight = scrollable.offsetHeight;
    var scrollTop = scrollable.scrollTop;

    if (scrollTop === 0 && deltaY < 0)
        event.preventDefault();
    else if (visibleHeight + scrollTop === contentHeight && deltaY > 0)
        event.preventDefault();
});*/
</script>



    

