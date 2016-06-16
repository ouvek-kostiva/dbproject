<meta charset='utf-8'>
<link href="./css/bootstrap.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="./css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="./css/starter-template.css" rel="stylesheet">
<form method="post">
    <div class="col-lg-3">
         <div class="input-group">
            <span class="input-group-addon">管理者帳號</span>
            <input type="text" class="form-control" placeholder="預設為 root" name="username" value="root">
         </div>
    </div>
    <div class="col-lg-3">
         <div class="input-group">
            <span class="input-group-addon">管理者密碼</span>
            <input type="password" class="form-control" placeholder="預設為空白" name="password" value="">
         </div>
    </div>
    <div class="col-lg-3">
         <div class="input-group">
            <span class="input-group-addon">資料庫名稱</span>
            <input type="text" class="form-control" placeholder="預設為 c9" name="dbname" value="c9">
         </div>
    </div>
    <div class="col-lg-2">
        <button type="submit" class="btn btn-default"/>
        <span class="glyphicon glyphicon-forward" aria-hidden="true"></span>
        新建資料表
        </button>
    </div>
</form>
</br>
</br>
<div class='alert alert-danger' role='alert'><h1><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 如已完成建立資料表, 請將這個資料夾(init)刪除!</div></h1></br>
<?php

/*創造 Table SQL 開始*/
//--------------------------------------------------------
//--------------------------------------------------------
//--------------------------------------------------------
//--------------------------------------------------------
//--------------------------------------------------------
$sql = "CREATE TABLE BOMs (BomProduct_id int(10) NOT NULL, BOM_id int(10) NOT NULL AUTO_INCREMENT, ChildItem_id int(10) NOT NULL, BOM_Remarks varchar(255), Quantity int(10) NOT NULL, PRIMARY KEY (BOM_id)) ENGINE=InnoDB;
CREATE TABLE Collections (Collection_id int(10) NOT NULL AUTO_INCREMENT, CollectionRemarks varchar(255), CollectionTotalAmount int(10) NOT NULL, CollectionDate time NOT NULL, CollectionPayMethod_id int(10) NOT NULL, CollectionInvoice_id int(10) NOT NULL, CollectionUser_id int(10) NOT NULL, PRIMARY KEY (Collection_id)) ENGINE=InnoDB;
CREATE TABLE CookieLog (CookieLog_id int(10) NOT NULL AUTO_INCREMENT, CookieLog_Cookie varchar(255) NOT NULL, CookieLog_User_id int(10) NOT NULL, Start time NOT NULL, `End` time, PRIMARY KEY (CookieLog_id)) ENGINE=InnoDB;
CREATE TABLE Customer (Customer_id int(10) NOT NULL AUTO_INCREMENT, Customercode varchar(255) NOT NULL, Customername varchar(255) NOT NULL, CustomerTel_1 varchar(255), CustomerTel_2 varchar(255), CustomerID varchar(255), CustomerEmail varchar(255) NOT NULL, CustomerWebsite varchar(255), CustomerType varchar(255) NOT NULL, CustomerBank varchar(255), CustomerBankNo varchar(255), CustomerAddress varchar(255), CustomerCompany varchar(255), CustomerRemarks varchar(255), CustomerUser_id int(10) NOT NULL, CustomerPayMethod_id int(10) NOT NULL, PRIMARY KEY (Customer_id)) ENGINE=InnoDB;
CREATE TABLE Delivery (Delivery_id int(10) NOT NULL AUTO_INCREMENT, DeliveryDate time NOT NULL, DeliveryAddress varchar(255), DeliveryRemarks varchar(255), DeliverySalesOrder_id int(10) NOT NULL, DeliveryUser_id int(10) NOT NULL, DeliveryDeliveryMethod_id int(10) NOT NULL, DeliveryCustomer_id int(10) NOT NULL, Delivery_Code varchar(255) NOT NULL, PRIMARY KEY (Delivery_id)) ENGINE=InnoDB;
CREATE TABLE Delivery_List (Delivery_List_Delivery_id int(10) NOT NULL, Delivery_List_Quantity int(10) NOT NULL, Delivery_List_Remarks varchar(255), Delivery_id varchar(255) NOT NULL, Delivery_List_Product_id int(10) NOT NULL, PRIMARY KEY (Delivery_List_Delivery_id)) ENGINE=InnoDB;
CREATE TABLE DeliveryMethod (DeliveryMethod_id int(10) NOT NULL AUTO_INCREMENT, DeliveryMethodName varchar(255) NOT NULL, PRIMARY KEY (DeliveryMethod_id)) ENGINE=InnoDB;
CREATE TABLE Employees (Employee_id int(10) NOT NULL AUTO_INCREMENT, Employeecode varchar(255) NOT NULL, Employeename varchar(255) NOT NULL, EmployeeDateHired time, EmployeeWorkPhone varchar(255), Employee_Email varchar(255), Position varchar(255), EmployeeDateEnd time, EmployeeID varchar(255), EmployeeAddress varchar(255), EmployeePersonalPhone varchar(255), EmployeeDepartment varchar(255), EmployeeRemarks varchar(255), EmployeeUser_id int(10) NOT NULL, Supervisor_id int(10) NOT NULL, PRIMARY KEY (Employee_id)) ENGINE=InnoDB;
CREATE TABLE GReceived (GReceived_id int(10) NOT NULL AUTO_INCREMENT, GR_Date time NOT NULL, GR_Remarks varchar(255), GR_PurchaseOrder_id int(10) NOT NULL, GR_User_id int(10) NOT NULL, GR_Vendor_id int(10) NOT NULL, VendorVendorcode varchar(255) NOT NULL, GR_Code varchar(255) NOT NULL, PRIMARY KEY (GReceived_id)) ENGINE=InnoDB;
CREATE TABLE GReceived_List (GR_List_GReceived_id int(10) NOT NULL, GR_List_Quantity int(10) NOT NULL, GR_List_Remarks varchar(255), GRList_id varchar(255) NOT NULL, GR_List_Product_id int(10) NOT NULL, PRIMARY KEY (GR_List_GReceived_id)) ENGINE=InnoDB;
CREATE TABLE Invoice (Invoice_id int(10) NOT NULL AUTO_INCREMENT, InvoiceDate time NOT NULL, InvoiceCode varchar(255), InvoiceRemarks varchar(255), InvoiceTotalAmount int(10) NOT NULL, InvoicePaymentMethod_id int(10) NOT NULL, InvoiceSalesOrder_id int(10) NOT NULL, InvoiceUser_id int(10) NOT NULL, PRIMARY KEY (Invoice_id)) ENGINE=InnoDB;
CREATE TABLE Issue (Issue_id int(10) NOT NULL AUTO_INCREMENT, Issue_Date time NOT NULL, Issue_Remarks varchar(255) NOT NULL, Issuecode varchar(255) NOT NULL, PRIMARY KEY (Issue_id)) ENGINE=InnoDB;
CREATE TABLE Issue_List (Issue_List_Issue_id int(10) NOT NULL, Issue_List_Quantity int(10) NOT NULL, Issue_List_Remarks varchar(255), IssueList_id varchar(255) NOT NULL, Issue_List_Product_id int(10) NOT NULL, PRIMARY KEY (Issue_List_Issue_id)) ENGINE=InnoDB;
CREATE TABLE Payment (Payment_id int(10) NOT NULL AUTO_INCREMENT, Payment_Remarks varchar(255), PaymentDate time NOT NULL, PaymentTotalAmount int(10) NOT NULL, PaymentReceipt_id int(10) NOT NULL, PaymentPaymentMethod_id int(10) NOT NULL, PaymentUser_id int(10) NOT NULL, PRIMARY KEY (Payment_id)) ENGINE=InnoDB;
CREATE TABLE PaymentMethod (PaymentMethod_id int(10) NOT NULL AUTO_INCREMENT, PaymentName varchar(255) NOT NULL, PRIMARY KEY (PaymentMethod_id)) ENGINE=InnoDB;
CREATE TABLE Production (Production_id int(10) NOT NULL AUTO_INCREMENT, Production_Remarks varchar(255), Production_Status varchar(255) NOT NULL, ProductionBOM_id int(10) NOT NULL, Produce_Quantity int(10) NOT NULL, Produce_Unit varchar(255), PRIMARY KEY (Production_id)) ENGINE=InnoDB;
CREATE TABLE Production_List (ProductionProduction_id int(10) NOT NULL, Production_List_Quantity int(10) NOT NULL, Production_List_Remarks varchar(255), ProductionList_id varchar(255) NOT NULL, Production_List_Product_id int(10) NOT NULL, PRIMARY KEY (ProductionProduction_id)) ENGINE=InnoDB;
CREATE TABLE Products (Product_id int(10) NOT NULL AUTO_INCREMENT, Productcode varchar(255) NOT NULL, Product_Barcode varchar(255), Productname varchar(255) NOT NULL, Unit varchar(255), Product_Remarks varchar(255), ProductImage blob, ProductImageName varchar(255), Productname2 varchar(255), PRIMARY KEY (Product_id)) ENGINE=InnoDB;
CREATE TABLE PurchaseOrder (PurchaseOrder_id int(10) NOT NULL AUTO_INCREMENT, PO_Date time NOT NULL, PO_ValidDate time, PO_Address varchar(255), PO_Amount int(10) NOT NULL, PO_Vendor_id int(10) NOT NULL, PO_User_id int(10) NOT NULL, VendorVendorcode varchar(255) NOT NULL, PO_Code varchar(255) NOT NULL, PRIMARY KEY (PurchaseOrder_id)) ENGINE=InnoDB;
CREATE TABLE PurchaseOrder_List (PO_List_PurchaseOrder_id int(10) NOT NULL, PO_List_Quantity int(10) NOT NULL, PO_List_Discount int(10), PO_List_UnitPrice int(10) NOT NULL, PO_List_Tax int(10), PO_List_Remarks varchar(255), POList_id int(11) NOT NULL, PO_List_Product_id int(10) NOT NULL, PO_Amount varchar(255), PRIMARY KEY (PO_List_PurchaseOrder_id)) ENGINE=InnoDB;
CREATE TABLE PurchaseQuotation (PurchaseQuotation_id int(10) NOT NULL AUTO_INCREMENT, PQ_Date time NOT NULL, PQ_ValidDate time, PQ_Amount int(10) NOT NULL, VendorVendor_id int(10) NOT NULL, UsersUser_id int(10) NOT NULL, VendorVendorcode varchar(255) NOT NULL, PQ_Code varchar(255) NOT NULL, PRIMARY KEY (PurchaseQuotation_id)) ENGINE=InnoDB;
CREATE TABLE PurchaseQuotation_List (PQ_List_PurchaseQuotation_id int(10) NOT NULL, PQ_List_Quantity int(10) NOT NULL, PQ_List_Discount int(10), PQ_List_UnitPrice int(10) NOT NULL, PQ_List_Tax int(10), PQ_List_Remarks varchar(255), PQList_id varchar(255) NOT NULL, PQ_List_Product_id int(10) NOT NULL, PQ_Amount varchar(255), PRIMARY KEY (PQ_List_PurchaseQuotation_id)) ENGINE=InnoDB;
CREATE TABLE Receipt (Receipt_id int(10) NOT NULL AUTO_INCREMENT, ReceiptDate time NOT NULL, ReceiptCode varchar(255) NOT NULL, ReceiptRemarks varchar(255), ReceiptTotalAmount int(10) NOT NULL, ReceiptPurchaseOrder_id int(10), ReceiptPaymentMethod_id int(10) NOT NULL, ReceiptUser_id int(10) NOT NULL, PRIMARY KEY (Receipt_id)) ENGINE=InnoDB;
CREATE TABLE Receive (Receive_id int(10) NOT NULL AUTO_INCREMENT, Receive_Date time NOT NULL, Receive_Remarks varchar(255), Receivecode varchar(255) NOT NULL, PRIMARY KEY (Receive_id)) ENGINE=InnoDB;
CREATE TABLE Receive_List (Receive_List_Quantity int(10) NOT NULL, Receive_List_Remarks varchar(255), Receive_List_UnitPrice int(10) NOT NULL, Receive_List_Receive_id int(10) NOT NULL, ReceiveList_id varchar(255) NOT NULL, Receive_List_Product_id int(10) NOT NULL, PRIMARY KEY (Receive_List_Receive_id)) ENGINE=InnoDB;
CREATE TABLE Reject (Reject_id int(10) NOT NULL AUTO_INCREMENT, RejectCode varchar(255) NOT NULL, RejectDate int(10), RejectGReceived_id int(10) NOT NULL, RejectVendor_id int(10) NOT NULL, RejectUser_id int(10) NOT NULL, RejectRemarks varchar(255), VendorVendorcode varchar(255) NOT NULL, PRIMARY KEY (Reject_id)) ENGINE=InnoDB;
CREATE TABLE Reject_List (Reject_GR_List_GReceived_id int(10) NOT NULL, Reject_List_Reject_id int(10) NOT NULL, Reject_List_Quantity int(10) NOT NULL, RejectList_id varchar(255) NOT NULL, PRIMARY KEY (Reject_GR_List_GReceived_id, Reject_List_Reject_id)) ENGINE=InnoDB;
CREATE TABLE Returns (Return_id int(10) NOT NULL AUTO_INCREMENT, ReturnCode varchar(255) NOT NULL, ReturnDate time NOT NULL, ReturnDelivery_id int(10) NOT NULL, ReturnCustomer_id int(10) NOT NULL, ReturnUser_id int(10) NOT NULL, PRIMARY KEY (Return_id)) ENGINE=InnoDB;
CREATE TABLE Returns_List (Return_Delivery_List_Delivery_id int(10) NOT NULL, Return_List_Return_id int(10) NOT NULL, Return_List_Quantity int(10) NOT NULL, ReturnList_id varchar(255) NOT NULL, PRIMARY KEY (Return_Delivery_List_Delivery_id, Return_List_Return_id)) ENGINE=InnoDB;
CREATE TABLE SalesOrder (SalesOrder_id int(10) NOT NULL AUTO_INCREMENT, SO_Date time NOT NULL, SO_ReqDate time, SO_Address varchar(255), SO_Customer_id int(10) NOT NULL, SO_User_id int(10) NOT NULL, SO_DeliveryMethod_id int(10) NOT NULL, SO_Code varchar(255) NOT NULL, SO_Amount varchar(255), PRIMARY KEY (SalesOrder_id)) ENGINE=InnoDB;
CREATE TABLE SalesOrder_List (SO_List_SalesOrder_id int(10) NOT NULL, SO_List_Quantity int(10) NOT NULL, SO_List_Discount int(10), SO_List_UnitPrice int(10) NOT NULL, SO_List_Tax int(10), SO_List_Remarks varchar(255), SOList_id varchar(255) NOT NULL, SO_Product_id int(10) NOT NULL, PRIMARY KEY (SO_List_SalesOrder_id)) ENGINE=InnoDB;
CREATE TABLE SalesQuotation (SalesQuotation_id int(10) NOT NULL AUTO_INCREMENT, SQ_Date time NOT NULL, SQ_ReqiredDate time, SQ_Address varchar(255), SQ_User_id int(10) NOT NULL, SQ_DeliveryMethod_id int(10) NOT NULL, SQ_Amount varchar(255), SQ_Customer_id int(10) NOT NULL, SQ_Code varchar(255) NOT NULL, PRIMARY KEY (SalesQuotation_id)) ENGINE=InnoDB;
CREATE TABLE SalesQuotation_List (SQ_List_SalesQuotation_id int(10) NOT NULL, SQ_List_Quantity int(10) NOT NULL, SQ_List_Discount int(10), SQ_List_UnitPrice int(10) NOT NULL, SQ_List_Tax int(10), SQ_List_Remarks varchar(255), SQList_id varchar(255) NOT NULL, SQ_Product_id int(10) NOT NULL, PRIMARY KEY (SQ_List_SalesQuotation_id)) ENGINE=InnoDB;
CREATE TABLE Users (User_id int(10) NOT NULL AUTO_INCREMENT, Usercode varchar(255), Username varchar(255) NOT NULL, Realname varchar(255), Address varchar(255), Sex smallint(3), Email varchar(255) NOT NULL, Passhash varchar(1024) NOT NULL, Salt varchar(1024) NOT NULL, userCookie varchar(255), Mobile varchar(255), Telephone varchar(255), Permission varchar(255) NOT NULL, Remarks varchar(255), UserPhoto blob, UserPhotoName varchar(255), PRIMARY KEY (User_id)) ENGINE=InnoDB;
CREATE TABLE Vendor (Vendor_id int(10) NOT NULL AUTO_INCREMENT, Vendorcode varchar(255) NOT NULL, Vendorname varchar(255) NOT NULL, VendorTel_1 varchar(255), VendorTel_2 varchar(255), VendorID varchar(255), VendorEmail varchar(255) NOT NULL, VendorWebsite varchar(255), VendorType varchar(255) NOT NULL, VendorBank varchar(255), VendorBankNo varchar(255), VendorAddress varchar(255), VendorCompany varchar(255), VendorRemarks varchar(255), VendorUser_id int(10) NOT NULL, VendorPayMethod_id int(10) NOT NULL, PRIMARY KEY (Vendor_id)) ENGINE=InnoDB;
ALTER TABLE Delivery_List ADD INDEX FKDelivery_L521330 (Delivery_List_Product_id), ADD CONSTRAINT FKDelivery_L521330 FOREIGN KEY (Delivery_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE SalesOrder_List ADD INDEX FKSalesOrder772450 (SO_Product_id), ADD CONSTRAINT FKSalesOrder772450 FOREIGN KEY (SO_Product_id) REFERENCES Products (Product_id);
ALTER TABLE SalesQuotation_List ADD INDEX FKSalesQuota449007 (SQ_Product_id), ADD CONSTRAINT FKSalesQuota449007 FOREIGN KEY (SQ_Product_id) REFERENCES Products (Product_id);
ALTER TABLE Issue_List ADD INDEX FKIssue_List839149 (Issue_List_Product_id), ADD CONSTRAINT FKIssue_List839149 FOREIGN KEY (Issue_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE GReceived_List ADD INDEX FKGReceived_854469 (GR_List_Product_id), ADD CONSTRAINT FKGReceived_854469 FOREIGN KEY (GR_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE PurchaseOrder_List ADD INDEX FKPurchaseOr345458 (PO_List_Product_id), ADD CONSTRAINT FKPurchaseOr345458 FOREIGN KEY (PO_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE PurchaseQuotation_List ADD INDEX FKPurchaseQu602757 (PQ_List_Product_id), ADD CONSTRAINT FKPurchaseQu602757 FOREIGN KEY (PQ_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE Receive_List ADD INDEX FKReceive_Li651237 (Receive_List_Product_id), ADD CONSTRAINT FKReceive_Li651237 FOREIGN KEY (Receive_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE Production_List ADD INDEX FKProduction303332 (Production_List_Product_id), ADD CONSTRAINT FKProduction303332 FOREIGN KEY (Production_List_Product_id) REFERENCES Products (Product_id);
ALTER TABLE SalesQuotation ADD INDEX FKSalesQuota471090 (SQ_Customer_id), ADD CONSTRAINT FKSalesQuota471090 FOREIGN KEY (SQ_Customer_id) REFERENCES Customer (Customer_id);
ALTER TABLE BOMs ADD INDEX FKBOMs712869 (BomProduct_id), ADD CONSTRAINT FKBOMs712869 FOREIGN KEY (BomProduct_id) REFERENCES Products (Product_id);
ALTER TABLE BOMs ADD INDEX FKBOMs818028 (ChildItem_id), ADD CONSTRAINT FKBOMs818028 FOREIGN KEY (ChildItem_id) REFERENCES BOMs (BOM_id);
ALTER TABLE Customer ADD INDEX FKCustomer690418 (CustomerUser_id), ADD CONSTRAINT FKCustomer690418 FOREIGN KEY (CustomerUser_id) REFERENCES Users (User_id);
ALTER TABLE Vendor ADD INDEX FKVendor723328 (VendorUser_id), ADD CONSTRAINT FKVendor723328 FOREIGN KEY (VendorUser_id) REFERENCES Users (User_id);
ALTER TABLE Employees ADD INDEX FKEmployees573703 (EmployeeUser_id), ADD CONSTRAINT FKEmployees573703 FOREIGN KEY (EmployeeUser_id) REFERENCES Users (User_id);
ALTER TABLE SalesQuotation ADD INDEX FKSalesQuota738755 (SQ_User_id), ADD CONSTRAINT FKSalesQuota738755 FOREIGN KEY (SQ_User_id) REFERENCES Users (User_id);
ALTER TABLE SalesOrder ADD INDEX FKSalesOrder128300 (SO_Customer_id), ADD CONSTRAINT FKSalesOrder128300 FOREIGN KEY (SO_Customer_id) REFERENCES Customer (Customer_id);
ALTER TABLE SalesOrder ADD INDEX FKSalesOrder767793 (SO_User_id), ADD CONSTRAINT FKSalesOrder767793 FOREIGN KEY (SO_User_id) REFERENCES Users (User_id);
ALTER TABLE Delivery ADD INDEX FKDelivery59253 (DeliverySalesOrder_id), ADD CONSTRAINT FKDelivery59253 FOREIGN KEY (DeliverySalesOrder_id) REFERENCES SalesOrder (SalesOrder_id);
ALTER TABLE Delivery ADD INDEX FKDelivery881901 (DeliveryUser_id), ADD CONSTRAINT FKDelivery881901 FOREIGN KEY (DeliveryUser_id) REFERENCES Users (User_id);
ALTER TABLE Invoice ADD INDEX FKInvoice632502 (InvoicePaymentMethod_id), ADD CONSTRAINT FKInvoice632502 FOREIGN KEY (InvoicePaymentMethod_id) REFERENCES PaymentMethod (PaymentMethod_id);
ALTER TABLE Customer ADD INDEX FKCustomer906963 (CustomerPayMethod_id), ADD CONSTRAINT FKCustomer906963 FOREIGN KEY (CustomerPayMethod_id) REFERENCES PaymentMethod (PaymentMethod_id);
ALTER TABLE Vendor ADD INDEX FKVendor785020 (VendorPayMethod_id), ADD CONSTRAINT FKVendor785020 FOREIGN KEY (VendorPayMethod_id) REFERENCES PaymentMethod (PaymentMethod_id);
ALTER TABLE SalesOrder ADD INDEX FKSalesOrder688273 (SO_DeliveryMethod_id), ADD CONSTRAINT FKSalesOrder688273 FOREIGN KEY (SO_DeliveryMethod_id) REFERENCES DeliveryMethod (DeliveryMethod_id);
ALTER TABLE SalesQuotation ADD INDEX FKSalesQuota227713 (SQ_DeliveryMethod_id), ADD CONSTRAINT FKSalesQuota227713 FOREIGN KEY (SQ_DeliveryMethod_id) REFERENCES DeliveryMethod (DeliveryMethod_id);
ALTER TABLE Invoice ADD INDEX FKInvoice690014 (InvoiceSalesOrder_id), ADD CONSTRAINT FKInvoice690014 FOREIGN KEY (InvoiceSalesOrder_id) REFERENCES SalesOrder (SalesOrder_id);
ALTER TABLE Collections ADD INDEX FKCollection485272 (CollectionPayMethod_id), ADD CONSTRAINT FKCollection485272 FOREIGN KEY (CollectionPayMethod_id) REFERENCES PaymentMethod (PaymentMethod_id);
ALTER TABLE Collections ADD INDEX FKCollection538613 (CollectionInvoice_id), ADD CONSTRAINT FKCollection538613 FOREIGN KEY (CollectionInvoice_id) REFERENCES Invoice (Invoice_id);
ALTER TABLE Delivery ADD INDEX FKDelivery131782 (DeliveryDeliveryMethod_id), ADD CONSTRAINT FKDelivery131782 FOREIGN KEY (DeliveryDeliveryMethod_id) REFERENCES DeliveryMethod (DeliveryMethod_id);
ALTER TABLE Returns ADD INDEX FKReturns795392 (ReturnDelivery_id), ADD CONSTRAINT FKReturns795392 FOREIGN KEY (ReturnDelivery_id) REFERENCES Delivery (Delivery_id);
ALTER TABLE Delivery ADD INDEX FKDelivery596118 (DeliveryCustomer_id), ADD CONSTRAINT FKDelivery596118 FOREIGN KEY (DeliveryCustomer_id) REFERENCES Customer (Customer_id);
ALTER TABLE Returns ADD INDEX FKReturns23437 (ReturnCustomer_id), ADD CONSTRAINT FKReturns23437 FOREIGN KEY (ReturnCustomer_id) REFERENCES Customer (Customer_id);
ALTER TABLE SalesQuotation_List ADD INDEX FKSalesQuota195858 (SQ_List_SalesQuotation_id), ADD CONSTRAINT FKSalesQuota195858 FOREIGN KEY (SQ_List_SalesQuotation_id) REFERENCES SalesQuotation (SalesQuotation_id);
ALTER TABLE SalesOrder_List ADD INDEX FKSalesOrder483379 (SO_List_SalesOrder_id), ADD CONSTRAINT FKSalesOrder483379 FOREIGN KEY (SO_List_SalesOrder_id) REFERENCES SalesOrder (SalesOrder_id);
ALTER TABLE Delivery_List ADD INDEX FKDelivery_L33573 (Delivery_List_Delivery_id), ADD CONSTRAINT FKDelivery_L33573 FOREIGN KEY (Delivery_List_Delivery_id) REFERENCES Delivery (Delivery_id);
ALTER TABLE Returns_List ADD INDEX FKReturns_Li527267 (Return_Delivery_List_Delivery_id), ADD CONSTRAINT FKReturns_Li527267 FOREIGN KEY (Return_Delivery_List_Delivery_id) REFERENCES Delivery_List (Delivery_List_Delivery_id);
ALTER TABLE Returns_List ADD INDEX FKReturns_Li95274 (Return_List_Return_id), ADD CONSTRAINT FKReturns_Li95274 FOREIGN KEY (Return_List_Return_id) REFERENCES Returns (Return_id);
ALTER TABLE PurchaseQuotation ADD INDEX FKPurchaseQu782978 (VendorVendor_id), ADD CONSTRAINT FKPurchaseQu782978 FOREIGN KEY (VendorVendor_id) REFERENCES Vendor (Vendor_id);
ALTER TABLE PurchaseQuotation ADD INDEX FKPurchaseQu943506 (UsersUser_id), ADD CONSTRAINT FKPurchaseQu943506 FOREIGN KEY (UsersUser_id) REFERENCES Users (User_id);
ALTER TABLE PurchaseOrder ADD INDEX FKPurchaseOr387816 (PO_Vendor_id), ADD CONSTRAINT FKPurchaseOr387816 FOREIGN KEY (PO_Vendor_id) REFERENCES Vendor (Vendor_id);
ALTER TABLE PurchaseOrder ADD INDEX FKPurchaseOr425287 (PO_User_id), ADD CONSTRAINT FKPurchaseOr425287 FOREIGN KEY (PO_User_id) REFERENCES Users (User_id);
ALTER TABLE GReceived ADD INDEX FKGReceived826597 (GR_PurchaseOrder_id), ADD CONSTRAINT FKGReceived826597 FOREIGN KEY (GR_PurchaseOrder_id) REFERENCES PurchaseOrder (PurchaseOrder_id);
ALTER TABLE GReceived ADD INDEX FKGReceived34635 (GR_User_id), ADD CONSTRAINT FKGReceived34635 FOREIGN KEY (GR_User_id) REFERENCES Users (User_id);
ALTER TABLE GReceived ADD INDEX FKGReceived333519 (GR_Vendor_id), ADD CONSTRAINT FKGReceived333519 FOREIGN KEY (GR_Vendor_id) REFERENCES Vendor (Vendor_id);
ALTER TABLE Receipt ADD INDEX FKReceipt52443 (ReceiptPurchaseOrder_id), ADD CONSTRAINT FKReceipt52443 FOREIGN KEY (ReceiptPurchaseOrder_id) REFERENCES PurchaseOrder (PurchaseOrder_id);
ALTER TABLE Receipt ADD INDEX FKReceipt317252 (ReceiptPaymentMethod_id), ADD CONSTRAINT FKReceipt317252 FOREIGN KEY (ReceiptPaymentMethod_id) REFERENCES PaymentMethod (PaymentMethod_id);
ALTER TABLE Payment ADD INDEX FKPayment810278 (PaymentReceipt_id), ADD CONSTRAINT FKPayment810278 FOREIGN KEY (PaymentReceipt_id) REFERENCES Receipt (Receipt_id);
ALTER TABLE Payment ADD INDEX FKPayment632698 (PaymentPaymentMethod_id), ADD CONSTRAINT FKPayment632698 FOREIGN KEY (PaymentPaymentMethod_id) REFERENCES PaymentMethod (PaymentMethod_id);
ALTER TABLE Reject ADD INDEX FKReject572047 (RejectGReceived_id), ADD CONSTRAINT FKReject572047 FOREIGN KEY (RejectGReceived_id) REFERENCES GReceived (GReceived_id);
ALTER TABLE Reject ADD INDEX FKReject458325 (RejectVendor_id), ADD CONSTRAINT FKReject458325 FOREIGN KEY (RejectVendor_id) REFERENCES Vendor (Vendor_id);
ALTER TABLE Receipt ADD INDEX FKReceipt148312 (ReceiptUser_id), ADD CONSTRAINT FKReceipt148312 FOREIGN KEY (ReceiptUser_id) REFERENCES Users (User_id);
ALTER TABLE Payment ADD INDEX FKPayment717138 (PaymentUser_id), ADD CONSTRAINT FKPayment717138 FOREIGN KEY (PaymentUser_id) REFERENCES Users (User_id);
ALTER TABLE Reject ADD INDEX FKReject326834 (RejectUser_id), ADD CONSTRAINT FKReject326834 FOREIGN KEY (RejectUser_id) REFERENCES Users (User_id);
ALTER TABLE Returns ADD INDEX FKReturns504443 (ReturnUser_id), ADD CONSTRAINT FKReturns504443 FOREIGN KEY (ReturnUser_id) REFERENCES Users (User_id);
ALTER TABLE Collections ADD INDEX FKCollection632286 (CollectionUser_id), ADD CONSTRAINT FKCollection632286 FOREIGN KEY (CollectionUser_id) REFERENCES Users (User_id);
ALTER TABLE Invoice ADD INDEX FKInvoice842516 (InvoiceUser_id), ADD CONSTRAINT FKInvoice842516 FOREIGN KEY (InvoiceUser_id) REFERENCES Users (User_id);
ALTER TABLE PurchaseQuotation_List ADD INDEX FKPurchaseQu109463 (PQ_List_PurchaseQuotation_id), ADD CONSTRAINT FKPurchaseQu109463 FOREIGN KEY (PQ_List_PurchaseQuotation_id) REFERENCES PurchaseQuotation (PurchaseQuotation_id);
ALTER TABLE PurchaseOrder_List ADD INDEX FKPurchaseOr85898 (PO_List_PurchaseOrder_id), ADD CONSTRAINT FKPurchaseOr85898 FOREIGN KEY (PO_List_PurchaseOrder_id) REFERENCES PurchaseOrder (PurchaseOrder_id);
ALTER TABLE GReceived_List ADD INDEX FKGReceived_995696 (GR_List_GReceived_id), ADD CONSTRAINT FKGReceived_995696 FOREIGN KEY (GR_List_GReceived_id) REFERENCES GReceived (GReceived_id);
ALTER TABLE Reject_List ADD INDEX FKReject_Lis822506 (Reject_GR_List_GReceived_id), ADD CONSTRAINT FKReject_Lis822506 FOREIGN KEY (Reject_GR_List_GReceived_id) REFERENCES GReceived_List (GR_List_GReceived_id);
ALTER TABLE Reject_List ADD INDEX FKReject_Lis112605 (Reject_List_Reject_id), ADD CONSTRAINT FKReject_Lis112605 FOREIGN KEY (Reject_List_Reject_id) REFERENCES Reject (Reject_id);
ALTER TABLE Production_List ADD INDEX FKProduction495289 (ProductionProduction_id), ADD CONSTRAINT FKProduction495289 FOREIGN KEY (ProductionProduction_id) REFERENCES Production (Production_id);
ALTER TABLE Production ADD INDEX FKProduction536039 (ProductionBOM_id), ADD CONSTRAINT FKProduction536039 FOREIGN KEY (ProductionBOM_id) REFERENCES BOMs (BOM_id);
ALTER TABLE Receive_List ADD INDEX FKReceive_Li200403 (Receive_List_Receive_id), ADD CONSTRAINT FKReceive_Li200403 FOREIGN KEY (Receive_List_Receive_id) REFERENCES Receive (Receive_id);
ALTER TABLE Issue_List ADD INDEX FKIssue_List312724 (Issue_List_Issue_id), ADD CONSTRAINT FKIssue_List312724 FOREIGN KEY (Issue_List_Issue_id) REFERENCES Issue (Issue_id);
ALTER TABLE CookieLog ADD INDEX FKCookieLog329650 (CookieLog_User_id), ADD CONSTRAINT FKCookieLog329650 FOREIGN KEY (CookieLog_User_id) REFERENCES Users (User_id);
ALTER TABLE Employees ADD INDEX FKEmployees520979 (Supervisor_id), ADD CONSTRAINT FKEmployees520979 FOREIGN KEY (Supervisor_id) REFERENCES Employees (Employee_id);
ALTER TABLE  `SalesOrder_List` CHANGE  `SOList_id`  `SOList_id` INT( 10 ) NOT NULL ;
ALTER TABLE  `SalesOrder_List` DROP PRIMARY KEY ,
ADD PRIMARY KEY (  `SOList_id` ) ;
ALTER TABLE  `SalesOrder_List` CHANGE  `SOList_id`  `SOList_id` INT( 10 ) NOT NULL AUTO_INCREMENT ;
ALTER TABLE  `PurchaseOrder_List` DROP PRIMARY KEY ,
ADD PRIMARY KEY (  `POList_id` ) ;
ALTER TABLE  `PurchaseOrder_List` CHANGE  `POList_id`  `POList_id` INT( 11 ) NOT NULL AUTO_INCREMENT ;
ALTER TABLE  `PurchaseOrder` CHANGE  `PO_Amount`  `PO_Amount` INT( 10 ) NULL ;
ALTER TABLE  `PurchaseOrder` CHANGE  `PO_Date`  `PO_Date` DATETIME NOT NULL ;
ALTER TABLE  `PurchaseOrder` CHANGE  `PO_ValidDate`  `PO_ValidDate` DATETIME NULL DEFAULT NULL ;
ALTER TABLE  `SalesOrder` CHANGE  `SO_Date`  `SO_Date` DATETIME NOT NULL ;
ALTER TABLE  `SalesOrder` CHANGE  `SO_ReqDate`  `SO_ReqDate` DATETIME NULL DEFAULT NULL ;
ALTER TABLE  `Users` CHANGE  `Sex`  `Sex` VARCHAR( 10 ) NULL DEFAULT NULL ;
ALTER TABLE  `Products` ADD  `Product_Qty` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE  `SalesOrder` CHANGE  `SO_DeliveryMethod_id`  `SO_DeliveryMethod_id` INT( 10 ) NULL ;
ALTER TABLE  `Receive` CHANGE  `Receive_Date`  `Receive_Date` DATETIME NOT NULL ;
ALTER TABLE  `Issue` CHANGE  `Issue_Date`  `Issue_Date` DATETIME NOT NULL ;
";
//--------------------------------------------------------
//--------------------------------------------------------
//--------------------------------------------------------
//--------------------------------------------------------
//--------------------------------------------------------
/*創造 Table SQL 結束*/


    $dbhost = '127.0.0.1';   
    $dbuser = trim($_POST['username']);   
    $dbpass = trim($_POST['password']);   
    $dbname = trim($_POST['dbname']);   

    if($dbuser != "" && $dbname != ""){
    
        $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
        
        $results = $conn->query("SHOW TABLES LIKE 'Users'");
        if(!($results->rowCount() > 0)) {
            echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'>資料庫不存在...</br>
            ".print_r($conn->errorInfo(), TRUE)."</br>
            開始建立資料庫</span></div>";
            try {
                $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpass);
                $conn->exec($sql);
                echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'>資料庫啟動完成</span></div>";
                echo "<script language=javascript>
                                window.setTimeout(function(){location.reload(); },1000);
                          </script>";
            }catch(PDOException $e){
                echo "<div class='alert alert-danger' role='alert'><br>" . $e->getMessage()."</div>";
            }
        }else{
            echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'>資料庫存在</span></div>";
            echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'>開始檢查必要資料...</span></div>";
            
            
            
            
            
            
            $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = 'Credit' ;");
            $select->execute(array(':ucook' => $_COOKIE['dbproject']));
            $row = $select->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                echo "<div class='alert alert-danger' role='alert'>無 Credit 支付方法...</div> ";
                $PaymentName = "Credit";
                $insert = $conn->prepare("INSERT INTO PaymentMethod (PaymentName) VALUES (:PaymentName) ;");
                $insert->execute(array(':PaymentName' => $PaymentName));
                $insert->fetch(PDO::FETCH_ASSOC);
                if($insert){
                    echo "<div class='alert alert-success' role='alert'> 新增 $PaymentName 支付方法成功 </div></br>";
                    echo "<script language=javascript>
                                window.setTimeout(function(){location.reload(); },1000);
                          </script>";
                }else{
                    echo "<div class='alert alert-danger' role='alert'>新增 $PaymentName 支付方法失敗</div></br>";
                }
            }else{
                echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 已有 Credit 支付方法 </div></br>";
            }
            
            $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = 'Cash' ;");
            $select->execute(array(':ucook' => $_COOKIE['dbproject']));
            $row = $select->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                echo "<div class='alert alert-danger' role='alert'>無 Cash 支付方法...</div> ";
                $PaymentName = "Cash";
                $insert = $conn->prepare("INSERT INTO PaymentMethod (PaymentName) VALUES (:PaymentName) ;");
                $insert->execute(array(':PaymentName' => $PaymentName));
                $insert->fetch(PDO::FETCH_ASSOC);
                if($insert){
                    echo "<div class='alert alert-success' role='alert'> 新增 $PaymentName 支付方法成功 </div></br>";
                    echo "<script language=javascript>
                                window.setTimeout(function(){location.reload(); },1000);
                          </script>";
                }else{
                    echo "<div class='alert alert-danger' role='alert'>新增 $PaymentName 支付方法失敗</div></br>";
                }
            }else{
                echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 已有 Cash 支付方法 </div></br>";
            }
            
            $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = 'Transfer' ;");
            $select->execute(array(':ucook' => $_COOKIE['dbproject']));
            $row = $select->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                echo "<div class='alert alert-danger' role='alert'>無 Transfer 支付方法...</div> ";
                $PaymentName = "Transfer";
                $insert = $conn->prepare("INSERT INTO PaymentMethod (PaymentName) VALUES (:PaymentName) ;");
                $insert->execute(array(':PaymentName' => $PaymentName));
                $insert->fetch(PDO::FETCH_ASSOC);
                if($insert){
                    echo "<div class='alert alert-success' role='alert'> 新增 $PaymentName 支付方法成功 </div></br>";
                    echo "<script language=javascript>
                                window.setTimeout(function(){location.reload(); },1000);
                          </script>";
                }else{
                    echo "<div class='alert alert-danger' role='alert'>新增 $PaymentName 支付方法失敗</div></br>";
                }
            }else{
                echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 已有 Transfer 支付方法 </div></br>";
            }
            
            
            $select = $conn->prepare("SELECT User_id FROM Users WHERE Username = 'Admin' ;");
            $select->execute();
            $row = $select->fetch(PDO::FETCH_ASSOC);
            if($select->rowCount() == 0){
                $pass_1 = "Admin";
                $Username = "Admin";
                $Email = "admin@email.com";
                $Permission = "General";
                echo "<div class='alert alert-danger' role='alert'>無 Admin 使用者...</div> ";
                $Salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM); //產生隨機數字
                $options = [
                    'cost' => 8,
                    'salt' => $Salt,
                ];
                $Passhash = password_hash($pass_1, PASSWORD_BCRYPT, $options); //密碼+隨機數字 進行 雜湊函數 運算
        
                $select = $conn->prepare("INSERT INTO Users (User_id, Username, Email, Passhash, Salt, Permission) VALUES (:User_id, :Username, :Email, :Passhash, :Salt, :Permission)"); //INSERT 資料進入資料庫
                $select->execute(array(
                    ':User_id' => NULL,
                    ':Username' => $Username,
                    ':Email' => $Email,
                    ':Passhash' => $Passhash,
                    ':Salt' => $Salt,
                    ':Permission' => $Permission
                ));
            }else{
                echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 已有 Admin 使用者 </div></br>";
            }
            
            $conn = null;
            
            
            }///
            
    }
            
            
            
            
            
        