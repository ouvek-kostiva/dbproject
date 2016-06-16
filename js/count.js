function calculatePercentage1 (unitprice, discount, tax, qty, results1) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results1").innerHTML = sum;
}
// Haven't changed below for javascript start
function calculatePercentage2 (unitprice, discount, tax, qty) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results2").innerHTML = sum;
    document.getElementById("totalamount").value = sum.toString();
}
function calculatePercentage3 (unitprice, discount, tax, qty) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results3").innerHTML = sum;
    document.getElementById("totalamount").value = sum.toString();
}
function calculatePercentage4 (unitprice, discount, tax, qty) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results4").innerHTML = sum;
    document.getElementById("totalamount").value = sum.toString();
}
function calculatePercentage5 (unitprice, discount, tax, qty) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results5").innerHTML = sum;
    document.getElementById("totalamount").value = sum.toString();
}
function calculatePercentage6 (unitprice, discount, tax, qty) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results6").innerHTML = sum;
    document.getElementById("totalamount").value = sum.toString();
}
function calculatePercentage7 (unitprice, discount, tax, qty) {
	sum = qty * unitprice;
	sum = sum - sum*discount;
    sum = sum + sum*tax ;
    document.getElementById("results7").innerHTML = sum;
    document.getElementById("totalamount").value = sum.toString();
}

// Haven't changed below for javascript end