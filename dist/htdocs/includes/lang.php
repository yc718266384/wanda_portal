<?php

	$lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
	if (strncasecmp($lang, "zh-cn", 5) == 0)
		$prefix = "cn";
	//else if (strncasecmp($lang, "zh-tw", 5) == 0)
	//	$prefix = "b";
	//else if (strncasecmp($lang, "ko", 2) == 0)
	//	$prefix = "k";
	//else if (strncasecmp($lang, "ja", 2) == 0)
	//	$prefix = "j";
	else
		$prefix = "en";



	$lang_r = array();

	$check_lang = array('en','cn');
	
	$lang_r['en'] = array();
	$lang_r['cn'] = array();
	

	$lang_r['en']['hotel_name'] = $hotel_name["en"];
	$lang_r['cn']['hotel_name'] = $hotel_name["cn"];

	$lang_r['en']['hotel_addr'] = $hotel_address["en"];
	$lang_r['cn']['hotel_addr'] = $hotel_address["cn"];

	$lang_r['en']['hotel_local'] = "Hotel &amp; Local Area Information";
	$lang_r['cn']['hotel_local'] = "酒店详细信息";

	$lang_r['en']['lang_change'] = "Change  Language ";
	$lang_r['cn']['lang_change'] = "语言切换 ";

	$lang_r['en']['langchange_close'] = "CLOSE";
	$lang_r['cn']['langchange_close'] = "关闭";

	$lang_r['en']['langchange_title'] = "Change Language";
	$lang_r['cn']['langchange_title'] = "语言切换";

	$lang_r['en']['langchange_langtips'] = "Please select the option most relevant to you.";
	$lang_r['cn']['langchange_langtips'] = "请选择您需要的语言";

	$lang_r['en']['langchange_cn'] = "China - Chinese";
	$lang_r['cn']['langchange_cn'] = "中国 - 中文";

	$lang_r['en']['langchange_en'] = "United States - English";
	$lang_r['cn']['langchange_en'] = "美国 - 英文";


	$lang_r['en']['vpass_title'] = "Free Internet for everyone";
	$lang_r['cn']['vpass_title'] = "免费宽带连接";				


	$lang_r['en']['vpass_text1'] = "Best for: Email, Web browsing";
	$lang_r['cn']['vpass_text1'] = "您可以：收发电子邮件，浏览网页等";


	$lang_r['en']['vpass_text2'] = "Free";
	$lang_r['cn']['vpass_text2'] = "免费";

	$lang_r['en']['vpass_text3'] = "Duration:";
	$lang_r['cn']['vpass_text3'] = "持续时间";

	$lang_r['en']['vpass_text4'] = "Length of Stay";
	$lang_r['cn']['vpass_text4'] = "住宿时长";


	$lang_r['en']['auth_title'] = 'A connection that can keep with you';
	$lang_r['cn']['auth_title'] = '您将始终享有互联网连接';

	$lang_r['en']['warningTip1'] = 'Room number and Last name is required.';
	$lang_r['cn']['warningTip1'] = '您的房间号和姓氏需填写';

	$lang_r['en']['Guest'] = 'In House Guest';
	$lang_r['cn']['Guest'] = '住店客人认证';

	$lang_r['en']['allFields'] = 'All fields are required';
	$lang_r['cn']['allFields'] = '请填写所有输入框';
	
	$lang_r['en']['RoomNo'] = 'Room number';
	$lang_r['cn']['RoomNo'] = '房间号码';

	$lang_r['en']['LastNa'] = 'Last name';
	$lang_r['cn']['LastNa'] = '姓氏';

	$lang_r['en']['auth_cun'] = 'CONNECT NOW';
	$lang_r['cn']['auth_cun'] = '连接';


	$lang_r['en']['pTip1'] = 'Please enter your information.';
	$lang_r['cn']['pTip1'] = '住店客人信息';

	$lang_r['en']['warningTip2'] = 'Access code is required.';
	$lang_r['cn']['warningTip2'] = '访问代码未填写';

	$lang_r['en']['Code'] = 'Connect With An Access Code';
	$lang_r['cn']['Code'] = '访问代码认证';

	$lang_r['en']['tTip1'] = 'Please enter your access code below.';
	$lang_r['cn']['tTip1'] = '请填写您的访问代码';

	$lang_r['en']['codes'] = 'Access code';
	$lang_r['cn']['codes'] = '访问代码';

	$lang_r['en']['code_cun'] = 'CONTINUE';
	$lang_r['cn']['code_cun'] = '连接上网';

	$lang_r['en']['pTip2'] = 'Enter access code to connect the internet.';
	$lang_r['cn']['pTip2'] = '输入访问代码连接网络';
		
	$lang_r['en']['err_infor_not_match'] = 'The information you entered doesn\'t match our records.';
	$lang_r['cn']['err_infor_not_match'] = '您输入的信息有误';

	$lang_r['en']['err_infor_not_match2'] = 'Please enter a valid mobile number.';
	$lang_r['cn']['err_infor_not_match2'] = '请输入有效的手机号码。';

	$lang_r['en']['Sms_success'] = 'Access code is being generated and will be delivered shortly.';
	$lang_r['cn']['Sms_success'] = '访问代码正在生成，将立即发送。';

	$lang_r['en']['warningTip3'] = 'Phone number and SMS code is required.';
	$lang_r['cn']['warningTip3'] = '手机号码及短信代码未填写';

	$lang_r['en']['Sms'] = 'Connect With A Sms Code';
	$lang_r['cn']['Sms'] = '短信代码认证';


	$lang_r['en']['sms_code'] = 'GET SMS CODE';
	$lang_r['cn']['sms_code'] = '获取短信代码';

	$lang_r['en']['sms_tips'] = 'Enter your SMS code here';
	$lang_r['cn']['sms_tips'] = '输入您的短信代码';

	$lang_r['en']['sms_resend'] = 'Resend after';
	$lang_r['cn']['sms_resend'] = '重新发送';


	$lang_r['en']['sms_verify'] = 'VERIFY CODE';
	$lang_r['cn']['sms_verify'] = '连接';

	$lang_r['en']['pTip3'] = 'Request an Access Code via SMS.';
	$lang_r['cn']['pTip3'] = '使用短信代码上网';

	$lang_r['en']['terms_tips'] = 'By selecting a connection option, you accept our';
	$lang_r['cn']['terms_tips'] = '点击连接即表示同意';

	$lang_r['en']['terms'] = 'terms of use';
	$lang_r['cn']['terms'] = '使用条款';

	$lang_r['en']['terms_close'] = 'CLOSE';
	$lang_r['cn']['terms_close'] = '关闭';

	$lang_r['en']['tips'] = 'Surfing or browsing foreign websites in China might not be accessible or slow due to Government regulations e.g. WhatsApp, Google, YouTube, Gmail, Facebook or Twitter.';
	$lang_r['cn']['tips'] = '友情提示，在中国大陆登录WhatsApp, Google, YouTube, Gmail, Facebook和 Twitter等网站的时候，可能会碰到网络速度很慢或者无法连接的状况。';

	$lang_r['en']['country_code'] = array("86"=>"China","93"=>"Afghanistan","355"=>"Albania","213"=>"Algeria","376"=>"Andorra","244"=>"Angola","1268"=>"Antigua and Barbuda","54"=>"Argentina","374"=>"Armenia","297"=>"Aruba I.","61"=>"Australia","994"=>"Azerbaijan","973"=>"Bahrain","880"=>"Bangladesh","1246"=>"Barbados","375"=>"Belarus","32"=>"Belgium","501"=>"Belize","229"=>"Benin","1441"=>"Bermuda Is.","975"=>"Bhutan","591"=>"Bolivia","387"=>"Bosnia And Herzegovina","267"=>"Botswana","55"=>"Brazil","359"=>"Bulgaria","226"=>"Burkina Faso","257"=>"Burundi","237"=>"Cameroon","1"=>"Canada","238"=>"Cape Verde","1345"=>"Cayman Is.","236"=>"Central Africa","235"=>"Chad","56"=>"Chile","57"=>"Colombia","269"=>"Comoro","242"=>"Congo","682"=>"Cook IS.","506"=>"Costa Rica","385"=>"Croatia","53"=>"Cuba","357"=>"Cyprus","420"=>"Czech","45"=>"Denmark","253"=>"Djibouti","593"=>"Ecuador","20"=>"Egypt","503"=>"El Salvador","240"=>"Equatorial Guinea","291"=>"Eritrea","372"=>"Estonia","251"=>"Ethiopia","500"=>"Falkland Is.","298"=>"Faroe Is.","679"=>"Fiji","358"=>"Finland","33"=>"France","594"=>"French Guiana","689"=>"French Polynesia","241"=>"Gabon","220"=>"Gambia","995"=>"Georgia","49"=>"Germany","233"=>"Ghana","350"=>"Gibraltar","30"=>"Greece","299"=>"Greenland","590"=>"Guadeloupe I.","671"=>"Guam","502"=>"Guatemala","245"=>"Guinea-Bissau","592"=>"Guyana","509"=>"Haiti","504"=>"Honduras","852"=>"Hong Kong(China)","36"=>"Hungary","354"=>"Iceland","91"=>"India","62"=>"Indonesia","98"=>"Iran","964"=>"Iraq","353"=>"Ireland","972"=>"Israel","39"=>"Italy","225"=>"Ivory Coast","1876"=>"Jamaica","81"=>"Japan","962"=>"Jordan","855"=>"Kampuchea","7"=>"Kazakhstan","254"=>"Kenya","686"=>"Kiribati","82"=>"Korea(republic of)","965"=>"Kuwait","996"=>"Kyrgyzstan","856"=>"Laos","371"=>"Latvia","961"=>"Lebanon","266"=>"Lesotho","231"=>"Liberia","218"=>"Libya","370"=>"Lithuania","352"=>"Luxembourg","853"=>"Macao(China)","389"=>"Macedonia","261"=>"Madagascar","265"=>"Malawi","60"=>"Malaysia","960"=>"Maldive","223"=>"Mali","356"=>"Malta","670"=>"Mariana Is.","596"=>"Martinique","222"=>"Mauritania","230"=>"Mauritius","52"=>"Mexico","373"=>"Moldova","377"=>"Monaco","976"=>"Mongolia","1664"=>"Montserrat I.","212"=>"Morocco","258"=>"Mozambique","95"=>"Myanmar","264"=>"Namibia","674"=>"Nauru","977"=>"Nepal","31"=>"Netherlands","599"=>"Netherlandsantilles Is.","687"=>"New Caledonia Is.","64"=>"New Zealand","505"=>"Nicaragua","227"=>"Niger","234"=>"Nigeria","683"=>"Niue I.","47"=>"Norway","968"=>"Oman","92"=>"Pakistan","680"=>"Palau","507"=>"Panama","675"=>"Papua New Guinea","595"=>"Paraguay","51"=>"Peru","63"=>"Philippines","48"=>"Poland","351"=>"Portugal","1787"=>"Puerto Rico","974"=>"Qatar","262"=>"Reunion I.","40"=>"Romania","250"=>"Rwanda","684"=>"Samoa=>Eastern","685"=>"Samoa=>Western","378"=>"San.Marino","966"=>"Saudi Arabia","221"=>"Senegal","248"=>"Seychelles","65"=>"Singapore","421"=>"Slovak","386"=>"Slovenia","677"=>"Solomon Is.","252"=>"Somali","27"=>"South Africa","34"=>"Spain","94"=>"Sri Lanka","1758"=>"St.Lucia","1784"=>"St.Vincent I.","249"=>"Sudan","597"=>"Suriname","268"=>"Swaziland","46"=>"Sweden","963"=>"Syria","886"=>"Taiwan(China)","992"=>"Tajikistan","255"=>"Tanzania","66"=>"Thailand","971"=>"The United Arab Emirates","228"=>"Togo","676"=>"Tonga","1809"=>"Trinidad and Tobago","216"=>"Tunisia","90"=>"Turkey","993"=>"Turkmenistan","688"=>"Tuvalu","01"=>"USA","256"=>"Uganda","380"=>"Ukraine","598"=>"Uruguay","998"=>"Uzbekistan","678"=>"Vanuatu","58"=>"Venezuela","84"=>"Vietnam","967"=>"Yemen","381"=>"Yugoslavia","243"=>"Zaire","260"=>"Zambia","263"=>"Zimbabwe");

	$lang_r['cn']['country_code'] = array("86"=>"中国","1"=>"加拿大","7"=>"哈萨克斯坦","20"=>"埃及","27"=>"南非","30"=>"希腊","31"=>"荷兰","32"=>"比利时","33"=>"法国","34"=>"西班牙","36"=>"匈牙利","39"=>"意大利","40"=>"罗马尼亚","41"=>"瑞士","43"=>"奥地利","44"=>"英国","45"=>"丹麦","46"=>"瑞典","47"=>"挪威","48"=>"波兰","49"=>"德国","51"=>"秘鲁","52"=>"墨西哥","53"=>"古巴","54"=>"阿根廷","55"=>"巴西","56"=>"智利","57"=>"哥伦比亚","58"=>"委内瑞拉","60"=>"马来西亚","61"=>"澳大利亚","62"=>"印度尼西亚","63"=>"菲律宾","64"=>"新西兰","65"=>"新加坡","66"=>"泰国","81"=>"日本","82"=>"韩国","84"=>"越南","90"=>"土耳其","91"=>"印度","92"=>"巴基斯坦","93"=>"阿富汗","94"=>"斯里兰卡","95"=>"缅甸","98"=>"伊朗","211"=>"南苏丹","212"=>"摩洛哥","213"=>"阿尔及利亚","216"=>"突尼斯","218"=>"利比亚","220"=>"冈比亚","221"=>"塞内加尔","222"=>"毛里塔尼亚","223"=>"马里","225"=>"科特迪瓦","226"=>"布基纳法索","227"=>"尼日尔","228"=>"多哥","229"=>"贝宁","230"=>"毛里求斯","231"=>"利比里亚","232"=>"塞拉利昂","233"=>"加纳","234"=>"尼日利亚","235"=>"乍得","236"=>"中非","237"=>"喀麦隆","238"=>"佛得角","240"=>"赤道几内亚","241"=>"加蓬","242"=>"刚果","243"=>"扎伊尔","244"=>"安哥拉","245"=>"几内亚比绍","248"=>"塞舌尔","249"=>"苏丹","250"=>"卢旺达","251"=>"埃塞俄比亚","252"=>"索马里","253"=>"吉布提","254"=>"肯尼亚","255"=>"坦桑尼亚","256"=>"乌干达","257"=>"布隆迪","258"=>"莫桑比克","260"=>"赞比亚","261"=>"马达加斯加","262"=>"留尼汪岛","263"=>"津巴布韦","264"=>"纳米比亚","265"=>"马拉维","266"=>"莱索托","267"=>"博茨瓦纳","268"=>"斯威士兰","269"=>"科摩罗","291"=>"厄立特里亚","297"=>"阿鲁巴岛","298"=>"法罗群岛(丹)","299"=>"格陵兰岛","350"=>"直布罗陀(英)","351"=>"葡萄牙","352"=>"卢森堡","353"=>"爱尔兰","354"=>"冰岛","355"=>"阿尔巴尼亚","356"=>"马耳他","357"=>"塞浦路斯","358"=>"芬兰","359"=>"保加利亚","370"=>"立陶宛","371"=>"拉脱维亚","372"=>"爱沙尼亚","373"=>"摩尔多瓦","374"=>"亚美尼亚","375"=>"白俄罗斯","376"=>"安道尔","377"=>"摩纳哥","378"=>"圣马力诺","380"=>"乌克兰","381"=>"南斯拉夫","382"=>"黑山","385"=>"克罗地亚","386"=>"斯洛文尼亚","387"=>"波斯尼亚和黑塞哥维那","389"=>"马其顿","420"=>"捷克","421"=>"斯洛伐克","423"=>"列支敦士登的","500"=>"福克兰群岛","501"=>"伯利兹","502"=>"危地马拉","503"=>"萨尔瓦多","504"=>"洪都拉斯","505"=>"尼加拉瓜","506"=>"哥斯达黎加","507"=>"巴拿马","509"=>"海地","590"=>"瓜德罗普岛(法)","591"=>"玻利维亚","592"=>"圭亚那","593"=>"厄瓜多尔","594"=>"法属圭亚那","595"=>"巴拉圭","596"=>"马提尼克(法)","597"=>"苏里南","598"=>"乌拉圭","599"=>"荷属安的列斯群岛","670"=>"马里亚纳群岛","671"=>"关岛(美)","673"=>"文莱","674"=>"瑙鲁","675"=>"巴布亚新几内亚","676"=>"汤加","677"=>"所罗门群岛","678"=>"瓦努阿图","679"=>"斐济","680"=>"帕劳(美)","682"=>"科克群岛(新)","683"=>"纽埃岛(新)","684"=>"东萨摩亚(美)","685"=>"西萨摩亚","686"=>"基里巴斯","687"=>"新喀里多尼亚群岛(法)","688"=>"图瓦卢","689"=>"法属波里尼西亚","852"=>"香港(中国)","853"=>"澳门(中国)","855"=>"柬埔寨","856"=>"老挝","880"=>"孟加拉国","886"=>"台湾(中国)","960"=>"马尔代夫","961"=>"黎巴嫩","962"=>"约旦","963"=>"叙利亚","964"=>"伊拉克","965"=>"科威特","966"=>"沙特阿拉伯","967"=>"也门","968"=>"阿曼","971"=>"阿拉伯联合酋长国","972"=>"以色列","973"=>"巴林","974"=>"卡塔尔","975"=>"不丹","976"=>"蒙古","977"=>"尼泊尔","992"=>"塔吉克斯坦","993"=>"土库曼斯坦","994"=>"阿塞拜疆","995"=>"格鲁吉亚","996"=>"吉尔吉斯斯坦","998"=>"乌兹别克斯坦","1242"=>"巴哈马","1246"=>"巴巴多斯","1264"=>"安圭拉岛","1268"=>"安提瓜和巴布达","1345"=>"开曼群岛(英)","1441"=>"百慕大群岛(英)","1649"=>"特克斯和凯科斯群岛","1664"=>"蒙特塞拉特岛(英)","1758"=>"圣卢西亚","1767"=>"多米尼加联邦","1784"=>"圣文森特岛(英)","1787"=>"波多黎各(美)","1809"=>"特立尼达和多巴哥","1869"=>"圣克里斯托弗和尼维斯","1876"=>"牙买加","1890"=>"多米尼加共和国");


?>
