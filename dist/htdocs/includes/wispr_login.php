<?
echo "<HTML><!--\r\n";
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
echo "<WISPAccessGatewayParam\r\n";
echo " xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\r\n";
echo " xsi:noNamespaceSchemaLocation=\"http://www.acmewisp.com/WISPAccessGatewayParam.xsd\">\r\n";
echo "<Redirect>\r\n";
echo "<AccessProcedure>1.0</AccessProcedure>\r\n";
echo "<AccessLocation>".$GIS_ID."</AccessLocation>\r\n";
echo "<LocationName>".$GIS_NAME."</LocationName>\r\n";
 echo "<LoginURL>".$GIS_URL."?sid=".$SID_INFO."</LoginURL>\r\n";
echo "<MessageType>100</MessageType>\r\n";
echo "<ResponseCode>0</ResponseCode>\r\n";
echo "</Redirect>\r\n";
echo "</WISPAccessGatewayParam>\r\n";
echo "--> </HTML>\r\n";
?>
