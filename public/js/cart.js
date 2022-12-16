$(document).ready(function() {
    // when + button click
    $(".btn-plus").click(function() {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find("#price").html().replace("kyats", ""));
        $qty = Number($parentNode.find("#qty").val());
        $total = $price * $qty;
        $parentNode.find("#total").html(`${$total}kyats`);
        summaryCalculation();
    });

    // when - button click
    $(".btn-minus").click(function() {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find("#price").html().replace("kyats", ""));
        $qty = Number($parentNode.find("#qty").val());
        $total = $price * $qty;
        $parentNode.find("#total").html(`${$total}kyats`);
        summaryCalculation();
    });


    //Calculate Final Price For Order
    function summaryCalculation() {
        $totalPrice = 0;
        //total summary
        $("#dataTable tr").each(function(index, row) {
            $totalPrice += Number($(row).find("#total").text().replace("kyats", ""));
        });
        $("#subTotalPrice").html(`${$totalPrice}kyats`);
        $("#finalResult").html(`${$totalPrice+3000} kyats`);
    }
});