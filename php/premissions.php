<?php
require_once'connect.php';
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];

//*****************  premissions
$result1 = $conn->query("SELECT premissions.*, pages.p_name FROM premissions INNER JOIN pages ON premissions.p_page = pages.ID WHERE p_user=$id") or die($conn->error());
while ($row1 = $result1->fetch_assoc()) {
if ($row1['p_name'] == 'التعليم'){
$learn = $row1['p_show'];
}
if ($row1['p_name'] == 'الدعوة'){
$call = $row1['p_show'];
}
if ($row1['p_name'] == 'المالية'){
$money = $row1['p_show'];
}
if ($row1['p_name'] == 'الادارة العامة'){
$manage = $row1['p_show'];
}
if ($row1['p_name'] == 'مسيرات الرواتب'){
$salary = $row1['p_show'];
}
if ($row1['p_name'] == 'مصروفات المراكز'){
$expensesm = $row1['p_show'];
}
if ($row1['p_name'] == 'نصيب الفرد'){
$portion = $row1['p_show'];
}
if ($row1['p_name'] == 'اعداد المهتدين'){
$countc = $row1['p_show'];
}
if ($row1['p_name'] == 'اعتماد تقارير التعليم'){
$lrok = $row1['p_show'];
}
if ($row1['p_name'] == 'تقارير التعليم'){
$lreports = $row1['p_show'];
}
if ($row1['p_name'] == 'مصروفات الدعوة'){
$minfo = $row1['p_show'];
}
if ($row1['p_name'] == 'الحركة الميدانية'){
$rprograms = $row1['p_show'];
}
if ($row1['p_name'] == 'اعتماد تقارير الدعوة'){
$crok = $row1['p_show'];
}
if ($row1['p_name'] == 'تقارير الدعوة'){
$creports = $row1['p_show'];
}
if ($row1['p_name'] == 'المصروفات العامة'){
$expenses = $row1['p_show'];
}
if ($row1['p_name'] == 'المصروفات التشغيلية'){
$expensesr = $row1['p_show'];
}
if ($row1['p_name'] == 'صرف العملة'){
$cash = $row1['p_show'];
}
if ($row1['p_name'] == 'المديونيات'){
$debts = $row1['p_show'];
}
if ($row1['p_name'] == 'الايرادات'){
$incomes = $row1['p_show'];
}
if ($row1['p_name'] == 'اعتماد التقارير المالية'){
$frok = $row1['p_show'];
}
if ($row1['p_name'] == 'التقارير المالية'){
$freports = $row1['p_show'];
}
if ($row1['p_name'] == 'شعارات التقارير'){
$logos = $row1['p_show'];
}
if ($row1['p_name'] == 'سعر الصرف'){
$exchange = $row1['p_show'];
}
if ($row1['p_name'] == 'المراكز'){
$marakez = $row1['p_show'];
}
if ($row1['p_name'] == 'الفرق'){
$groups = $row1['p_show'];
}
if ($row1['p_name'] == 'الموازنات'){
$comparison = $row1['p_show'];
}
if ($row1['p_name'] == 'الارصدة الافتتاحية'){
$balances = $row1['p_show'];
}
if ($row1['p_name'] == 'مواد نصيب الفرد'){
$items = $row1['p_show'];
}
if ($row1['p_name'] == 'بيانات الموازنات'){
$info = $row1['p_show'];
}
if ($row1['p_name'] == 'بنود الرواتب'){
$sitems = $row1['p_show'];
}
if ($row1['p_name'] == 'بنود المصروفات التشغيلية'){
$ritems = $row1['p_show'];
}
if ($row1['p_name'] == 'بنود مصروفات المراكز'){
$eitems = $row1['p_show'];
}
if ($row1['p_name'] == 'المستخدمين'){
$users = $row1['p_show'];
}
if ($row1['p_name'] == 'اعتماد التقارير'){
$rok = $row1['p_show'];
}
if ($row1['p_name'] == 'التقارير'){
$reports = $row1['p_show'];
}
}



//************** learn
if ($learn == 0){
$salary = 0;
$expensesm = 0;
$portion = 0;
$countc = 0;
$lrok = 0;
$lreports = 0;
}

//************ call
if ($call == 0){
$minfo = 0;
$rprograms = 0;
$crok = 0;
$creports = 0;
}


//************** finance
if ($money == 0){
$expenses = 0;
$expensesr = 0;
$cash = 0;
$debts = 0;
$incomes = 0;
$frok = 0;
$freports = 0;
}

//************ manage
if ($manage == 0){
$logos = 0;
$exchange = 0;
$marakez = 0;
$groups = 0;
$comparison = 0;
$balances = 0;
$items = 0;
$info = 0;
$sitems = 0;
$ritems = 0;
$eitems = 0;
$users = 0;
$rok = 0;
$reports = 0;
}
?>