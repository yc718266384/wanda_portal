<?
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
echo "<WISPAccessGatewayParam\r\n";
echo "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\r\n";
echo "xsi:noNamespaceSchemaLocation=\"http://www.acmewisp.com/WISPAccessGatewayParam.xsd\">\r\n";
echo "<AuthenticationReply>\r\n";
echo "<MessageType>120</MessageType>\r\n";
echo "<ResponseCode>50</ResponseCode>\r\n";
echo "<ReplyMessage>Replied By Local Authentication</ReplyMessage>\r\n";
echo "<LogoffURL>http://1.1.1.3/fcgi/websIpassLogoff</LogoffURL>\r\n";
echo "</AuthenticationReply>\r\n";
echo "</WISPAccessGatewayParam>\r\n";
?>
