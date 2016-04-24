<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>This example shows how to display nested Grid plugins.</title>
    <link rel="stylesheet" href="../../jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="../../scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="../../scripts/demos.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var url = "../sampledata/employees.xml";
            var source =
            {
                datafields: [
                    { name: 'FirstName' },
                    { name: 'LastName' },
                    { name: 'Title' },
                    { name: 'Address' },
                    { name: 'City' }
                ],
                root: "Employees",
                record: "Employee",
                id: 'EmployeeID',
                datatype: "xml",
                async: false,
                url: url
            };
            var employeesAdapter = new $.jqx.dataAdapter(source);
            var orderdetailsurl = "../sampledata/orderdetails.xml";
            var ordersSource =
            {
                datafields: [
                    { name: 'EmployeeID', type: 'string' },
                    { name: 'ShipName', type: 'string' },
                    { name: 'ShipAddress', type: 'string' },
                    { name: 'ShipCity', type: 'string' },
                    { name: 'ShipCountry', type: 'string' },
                    { name: 'ShippedDate', type: 'date' }
                ],
                root: "Orders",
                record: "Order",
                datatype: "xml",
                url: orderdetailsurl,
                async: false
            };
            var ordersDataAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: true });
            orders = ordersDataAdapter.records;
            var nestedGrids = new Array();
            // create nested grid.
            var initrowdetails = function (index, parentElement, gridElement, record) {
                var id = record.uid.toString();
                var grid = $($(parentElement).children()[0]);
                nestedGrids[index] = grid;
                var filtergroup = new $.jqx.filter();
                var filter_or_operator = 1;
                var filtervalue = id;
                var filtercondition = 'equal';
                var filter = filtergroup.createfilter('stringfilter', filtervalue, filtercondition);
                // fill the orders depending on the id.
                var ordersbyid = [];
                for (var m = 0; m < orders.length; m++) {
                    var result = filter.evaluate(orders[m]["EmployeeID"]);
                    if (result)
                        ordersbyid.push(orders[m]);
                }
                var orderssource = { datafields: [
                    { name: 'EmployeeID', type: 'string' },
                    { name: 'ShipName', type: 'string' },
                    { name: 'ShipAddress', type: 'string' },
                    { name: 'ShipCity', type: 'string' },
                    { name: 'ShipCountry', type: 'string' },
                    { name: 'ShippedDate', type: 'date' }
                ],
                    id: 'OrderID',
                    localdata: ordersbyid
                }
                var nestedGridAdapter = new $.jqx.dataAdapter(orderssource);
                if (grid != null) {
                    grid.jqxGrid({
                        source: nestedGridAdapter, width: 780, height: 200,
                        columns: [
                          { text: 'Ship Name', datafield: 'ShipName', width: 200 },
                          { text: 'Ship Address', datafield: 'ShipAddress', width: 200 },
                          { text: 'Ship City', datafield: 'ShipCity', width: 150 },
                          { text: 'Ship Country', datafield: 'ShipCountry', width: 150 },
                          { text: 'Shipped Date', datafield: 'ShippedDate', width: 200 }
                       ]
                    });
                }
            }
            var photorenderer = function (row, column, value) {
                var name = $('#jqxgrid').jqxGrid('getrowdata', row).FirstName;
                var imgurl = '../../images/' + name.toLowerCase() + '.png';
                var img = '<div style="background: white;"><img style="margin:2px; margin-left: 10px;" width="32" height="32" src="' + imgurl + '"></div>';
                return img;
            }
            var renderer = function (row, column, value) {
                return '<span style="margin-left: 4px; margin-top: 9px; float: left;">' + value + '</span>';
            }
            // creage jqxgrid
            $("#jqxgrid").jqxGrid(
            {
                width: 850,
                height: 365,
                source: source,
                rowdetails: true,
                rowsheight: 35,
                initrowdetails: initrowdetails,
                rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true },
                ready: function () {
                    $("#jqxgrid").jqxGrid('showrowdetails', 1);
                },
                columns: [
                      { text: 'Photo', width: 50, cellsrenderer: photorenderer },
                      { text: 'First Name', datafield: 'FirstName', width: 100, cellsrenderer: renderer },
                      { text: 'Last Name', datafield: 'LastName', width: 100, cellsrenderer: renderer },
                      { text: 'Title', datafield: 'Title', width: 180, cellsrenderer: renderer },
                      { text: 'Address', datafield: 'Address', width: 300, cellsrenderer: renderer },
                      { text: 'City', datafield: 'City', width: 170, cellsrenderer: renderer }
                  ]
            });
        });
    </script>
</head>
<body class='default'>
    <div id="jqxgrid">
    </div>
</body>
</html>

Terms of Use | Privacy Policy | Follow Us | Contact UsjQWidgets Facebook Fan PagejQWidgets Updates on Twitter jQWidgets Updates on Twitter
jQWidgets © 2011-2015. All Rights Reserved.
All product and company names herein are trademarks of their respective owners. 