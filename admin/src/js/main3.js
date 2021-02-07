
// function to show list of products
function showWork(){
 // get list of products from the API
$.getJSON("http://localhost/dt173g/api/work.php", function(data){
    // html for listing products
var work2_html=`
<!-- when clicked, it will load the create product form -->
<div id='create-work' class='btn btn-primary pull-right m-b-15px create-product-button'>
    <span class='glyphicon glyphicon-plus'></span> Create Product
</div><!-- start table -->
<table class='table table-bordered table-hover'>
 
    <!-- creating our table heading -->
    <tr>
        <th class='w-25-pct'>Name</th>
        <th class='w-10-pct'>Price</th>
        <th class='w-15-pct'>Category</th>
        <th class='w-25-pct text-align-center'>Action</th>
    </tr>`;
     
  // loop through returned list of data
$.each(data.records, function(key, val) {
 
    // creating new table row per record
    work2_html+=`
        <tr>
 
            <td>` + val.company + `</td>
            <td>$` + val.title + `</td>
            <td>` + val.startwork + `</td>
 
            <!-- 'action' buttons -->
            <td>
                <!-- read product button -->
                <button class='btn btn-primary m-r-10px read-one-product-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-eye-open'></span> Read
                </button>
 
                <!-- edit button -->
                <button class='btn btn-info m-r-10px update-product-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                </button>
 
                <!-- delete button -->
                <button class='btn btn-danger delete-product-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                </button>
            </td>
 
        </tr>`;
});
// inject to 'page-content' of our app
$("#page-content").html(work2_html);
 
// end table
read_products_html+=`</table>`;

 
});
}

