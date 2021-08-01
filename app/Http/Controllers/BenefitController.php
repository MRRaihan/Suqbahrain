<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers;
use App\Order;
use App\BusinessSetting;
use App\Seller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\WalletController;
use App\CustomerPackage;
use App\Http\Controllers\CustomerPackageController;
session_start();
class BenefitController extends Controller

{
    protected $msg = array();
	
	protected $logger;
    protected $AES_IV="PGKEYENCDECIVSPC"; //For Encryption/Decryption
	protected $AES_METHOD="AES-256-CBC";
	
	const countryArray = array(
	'Afghanistan'=>array('name'=>'Afghanistan','code'=>'004'),
'Ã…land Islands'=>array('name'=>'Ã…land Islands','code'=>'248'),
'Albania'=>array('name'=>'Albania','code'=>'008'),
'Algeria'=>array('name'=>'Algeria','code'=>'012'),
'American Samoa'=>array('name'=>'American Samoa','code'=>'016'),
'Andorra'=>array('name'=>'Andorra','code'=>'020'),
'Angola'=>array('name'=>'Angola','code'=>'024'),
'Anguilla'=>array('name'=>'Anguilla','code'=>'660'),
'Antarcticaâ€Š[a]'=>array('name'=>'Antarcticaâ€Š[a]','code'=>'010'),
'Antigua and Barbuda'=>array('name'=>'Antigua and Barbuda','code'=>'028'),
'Argentina'=>array('name'=>'Argentina','code'=>'032'),
'Armenia'=>array('name'=>'Armenia','code'=>'051'),
'Aruba'=>array('name'=>'Aruba','code'=>'533'),
'Australia'=>array('name'=>'Australiaâ€Š[b]','code'=>'036'),
'Austria'=>array('name'=>'Austria','code'=>'040'),
'Azerbaijan'=>array('name'=>'Azerbaijan','code'=>'031'),
'Bahamas'=>array('name'=>'Bahamas (the)','code'=>'044'),
'Bahrain'=>array('name'=>'Bahrain','code'=>'048'),
'Bangladesh'=>array('name'=>'Bangladesh','code'=>'050'),
'Barbados'=>array('name'=>'Barbados','code'=>'052'),
'Belarus'=>array('name'=>'Belarus','code'=>'112'),
'Belgium'=>array('name'=>'Belgium','code'=>'056'),
'Belize'=>array('name'=>'Belize','code'=>'084'),
'Benin'=>array('name'=>'Benin','code'=>'204'),
'Bermuda'=>array('name'=>'Bermuda','code'=>'060'),
'Bhutan'=>array('name'=>'Bhutan','code'=>'064'),
'Bolivia'=>array('name'=>'Bolivia (Plurinational State of)','code'=>'068'),
'Bonaire'=>array('name'=>'Bonaire','code'=>'535'),
'Bosnia and Herzegovina'=>array('name'=>'Bosnia and Herzegovina','code'=>'070'),
'Botswana'=>array('name'=>'Botswana','code'=>'072'),
'Bouvet Island'=>array('name'=>'Bouvet Island','code'=>'074'),
'Brazil'=>array('name'=>'Brazil','code'=>'076'),
'British Indian Ocean Territory (the)'=>array('name'=>'British Indian Ocean Territory (the)','code'=>'086'),
'Brunei Darussalam'=>array('name'=>'Brunei Darussalamâ€Š[e]','code'=>'096'),
'Bulgaria'=>array('name'=>'Bulgaria','code'=>'100'),
'Burkina Faso'=>array('name'=>'Burkina Faso','code'=>'854'),
'Burundi'=>array('name'=>'Burundi','code'=>'108'),
'Cabo Verdeâ€Š[f]'=>array('name'=>'Cabo Verdeâ€Š[f]','code'=>'132'),
'Cambodia'=>array('name'=>'Cambodia','code'=>'116'),
'Cameroon'=>array('name'=>'Cameroon','code'=>'120'),
'Canada'=>array('name'=>'Canada','code'=>'124'),
'Cayman Islands'=>array('name'=>'Cayman Islands (the)','code'=>'136'),
'Central African Republic'=>array('name'=>'Central African Republic (the)','code'=>'140'),
'Chad'=>array('name'=>'Chad','code'=>'148'),
'Chile'=>array('name'=>'Chile','code'=>'152'),
'China'=>array('name'=>'China','code'=>'156'),
'Christmas Island'=>array('name'=>'Christmas Island','code'=>'162'),
'Cocos (Keeling) Islands (the)'=>array('name'=>'Cocos (Keeling) Islands (the)','code'=>'166'),
'Colombia'=>array('name'=>'Colombia','code'=>'170'),
'Comoros'=>array('name'=>'Comoros (the)','code'=>'174'),
'Congo'=>array('name'=>'Congo (the Democratic Republic of the)','code'=>'180'),
'Congo (the)â€Š[g]'=>array('name'=>'Congo (the)â€Š[g]','code'=>'178'),
'Cook Islands'=>array('name'=>'Cook Islands (the)','code'=>'184'),
'Costa Rica'=>array('name'=>'Costa Rica','code'=>'188'),
'CÃ´te dIvoire'=>array('name'=>'CÃ´te dIvoire','code'=>'384'),
'Croatia'=>array('name'=>'Croatia','code'=>'191'),
'Cuba'=>array('name'=>'Cuba','code'=>'192'),
'CuraÃ§ao'=>array('name'=>'CuraÃ§ao','code'=>'531'),
'Cyprus'=>array('name'=>'Cyprus','code'=>'196'),
'Czech Republic'=>array('name'=>'Czechiaâ€Š[i]','code'=>'203'),
'Denmark'=>array('name'=>'Denmark','code'=>'208'),
'Djibouti'=>array('name'=>'Djibouti','code'=>'262'),
'Dominica'=>array('name'=>'Dominica','code'=>'212'),
'Dominican Republic'=>array('name'=>'Dominican Republic (the)','code'=>'214'),
'Ecuador'=>array('name'=>'Ecuador','code'=>'218'),
'Egypt'=>array('name'=>'Egypt','code'=>'818'),
'El Salvador'=>array('name'=>'El Salvador','code'=>'222'),
'Equatorial Guinea'=>array('name'=>'Equatorial Guinea','code'=>'226'),
'Eritrea'=>array('name'=>'Eritrea','code'=>'232'),
'Estonia'=>array('name'=>'Estonia','code'=>'233'),
'Eswatiniâ€Š[j]'=>array('name'=>'Eswatiniâ€Š[j]','code'=>'748'),
'Ethiopia'=>array('name'=>'Ethiopia','code'=>'231'),
'Falkland Islands (Malvinas)'=>array('name'=>'Falkland Islands (the) [Malvinas]â€Š[k]','code'=>'238'),
'Faroe Islands'=>array('name'=>'Faroe Islands (the)','code'=>'234'),
'Fiji'=>array('name'=>'Fiji','code'=>'242'),
'Finland'=>array('name'=>'Finland','code'=>'246'),
'France'=>array('name'=>'Franceâ€Š[l]','code'=>'250'),
'France, Metropolitan'=>array('name'=>'Franceâ€Š[l]','code'=>'250'),
'French Guiana'=>array('name'=>'French Guiana','code'=>'254'),
'French Polynesia'=>array('name'=>'French Polynesia','code'=>'258'),
'French Southern Territories'=>array('name'=>'French Southern Territories (the)â€Š[m]','code'=>'260'),
'Gabon'=>array('name'=>'Gabon','code'=>'266'),
'Gambia (the)'=>array('name'=>'Gambia (the)','code'=>'270'),
'Georgia'=>array('name'=>'Georgia','code'=>'268'),
'Germany'=>array('name'=>'Germany','code'=>'276'),
'Ghana'=>array('name'=>'Ghana','code'=>'288'),
'Gibraltar'=>array('name'=>'Gibraltar','code'=>'292'),
'Greece'=>array('name'=>'Greece','code'=>'300'),
'Greenland'=>array('name'=>'Greenland','code'=>'304'),
'Grenada'=>array('name'=>'Grenada','code'=>'308'),
'Guadeloupe'=>array('name'=>'Guadeloupe','code'=>'312'),
'Guam'=>array('name'=>'Guam','code'=>'316'),
'Guatemala'=>array('name'=>'Guatemala','code'=>'320'),
'Guernsey'=>array('name'=>'Guernsey','code'=>'831'),
'Guinea'=>array('name'=>'Guinea','code'=>'324'),
'Guinea-Bissau'=>array('name'=>'Guinea-Bissau','code'=>'624'),
'Guyana'=>array('name'=>'Guyana','code'=>'328'),
'Haiti'=>array('name'=>'Haiti','code'=>'332'),
'Heard Island and McDonald Islands'=>array('name'=>'Heard Island and McDonald Islands','code'=>'334'),
'Holy See (the)â€Š[n]'=>array('name'=>'Holy See (the)â€Š[n]','code'=>'336'),
'Honduras'=>array('name'=>'Honduras','code'=>'340'),
'Hong Kong'=>array('name'=>'Hong Kong','code'=>'344'),
'Hungary'=>array('name'=>'Hungary','code'=>'348'),
'Iceland'=>array('name'=>'Iceland','code'=>'352'),
'India'=>array('name'=>'India','code'=>'356'),
'Indonesia'=>array('name'=>'Indonesia','code'=>'360'),
'Iran (Islamic Republic of)'=>array('name'=>'Iran (Islamic Republic of)','code'=>'364'),
'Iraq'=>array('name'=>'Iraq','code'=>'368'),
'Ireland'=>array('name'=>'Ireland','code'=>'372'),
'Isle of Man'=>array('name'=>'Isle of Man','code'=>'833'),
'Israel'=>array('name'=>'Israel','code'=>'376'),
'Italy'=>array('name'=>'Italy','code'=>'380'),
'Jamaica'=>array('name'=>'Jamaica','code'=>'388'),
'Japan'=>array('name'=>'Japan','code'=>'392'),
'Jersey'=>array('name'=>'Jersey','code'=>'832'),
'Jordan'=>array('name'=>'Jordan','code'=>'400'),
'Kazakhstan'=>array('name'=>'Kazakhstan','code'=>'398'),
'Kenya'=>array('name'=>'Kenya','code'=>'404'),
'Kiribati'=>array('name'=>'Kiribati','code'=>'296'),
'Korea'=>array('name'=>'Korea','code'=>'408'),
'Korea (the Republic of)â€Š[p]'=>array('name'=>'Korea (the Republic of)â€Š[p]','code'=>'410'),
'Kuwait'=>array('name'=>'Kuwait','code'=>'414'),
'Kyrgyzstan'=>array('name'=>'Kyrgyzstan','code'=>'417'),
'Lao Peoples Democratic Republic'=>array('name'=>'Lao Peoples Democratic Republic','code'=>'418'),
'Latvia'=>array('name'=>'Latvia','code'=>'428'),
'Lebanon'=>array('name'=>'Lebanon','code'=>'422'),
'Lesotho'=>array('name'=>'Lesotho','code'=>'426'),
'Liberia'=>array('name'=>'Liberia','code'=>'430'),
'Libya'=>array('name'=>'Libya','code'=>'434'),
'Liechtenstein'=>array('name'=>'Liechtenstein','code'=>'438'),
'Lithuania'=>array('name'=>'Lithuania','code'=>'440'),
'Luxembourg'=>array('name'=>'Luxembourg','code'=>'442'),
'Macaoâ€Š[r]'=>array('name'=>'Macaoâ€Š[r]','code'=>'446'),
'North Macedoniaâ€Š[s]'=>array('name'=>'North Macedoniaâ€Š[s]','code'=>'807'),
'Madagascar'=>array('name'=>'Madagascar','code'=>'450'),
'Malawi'=>array('name'=>'Malawi','code'=>'454'),
'Malaysia'=>array('name'=>'Malaysia','code'=>'458'),
'Maldives'=>array('name'=>'Maldives','code'=>'462'),
'Mali'=>array('name'=>'Mali','code'=>'466'),
'Malta'=>array('name'=>'Malta','code'=>'470'),
'Marshall Islands (the)'=>array('name'=>'Marshall Islands (the)','code'=>'584'),
'Martinique'=>array('name'=>'Martinique','code'=>'474'),
'Mauritania'=>array('name'=>'Mauritania','code'=>'478'),
'Mauritius'=>array('name'=>'Mauritius','code'=>'480'),
'Mayotte'=>array('name'=>'Mayotte','code'=>'175'),
'Mexico'=>array('name'=>'Mexico','code'=>'484'),
'Micronesia (Federated States of)'=>array('name'=>'Micronesia (Federated States of)','code'=>'583'),
'Moldova (the Republic of)'=>array('name'=>'Moldova (the Republic of)','code'=>'498'),
'Monaco'=>array('name'=>'Monaco','code'=>'492'),
'Mongolia'=>array('name'=>'Mongolia','code'=>'496'),
'Montenegro'=>array('name'=>'Montenegro','code'=>'499'),
'Montserrat'=>array('name'=>'Montserrat','code'=>'500'),
'Morocco'=>array('name'=>'Morocco','code'=>'504'),
'Mozambique'=>array('name'=>'Mozambique','code'=>'508'),
'Myanmarâ€Š[t]'=>array('name'=>'Myanmarâ€Š[t]','code'=>'104'),
'Namibia'=>array('name'=>'Namibia','code'=>'516'),
'Nauru'=>array('name'=>'Nauru','code'=>'520'),
'Nepal'=>array('name'=>'Nepal','code'=>'524'),
'Netherlands (the)'=>array('name'=>'Netherlands (the)','code'=>'528'),
'New Caledonia'=>array('name'=>'New Caledonia','code'=>'540'),
'New Zealand'=>array('name'=>'New Zealand','code'=>'554'),
'Nicaragua'=>array('name'=>'Nicaragua','code'=>'558'),
'Niger'=>array('name'=>'Niger (the)','code'=>'562'),
'Nigeria'=>array('name'=>'Nigeria','code'=>'566'),
'Niue'=>array('name'=>'Niue','code'=>'570'),
'Norfolk Island'=>array('name'=>'Norfolk Island','code'=>'574'),
'Northern Mariana Islands (the)'=>array('name'=>'Northern Mariana Islands (the)','code'=>'580'),
'Norway'=>array('name'=>'Norway','code'=>'578'),
'Oman'=>array('name'=>'Oman','code'=>'512'),
'Pakistan'=>array('name'=>'Pakistan','code'=>'586'),
'Palau'=>array('name'=>'Palau','code'=>'585'),
'Palestine'=>array('name'=>'Palestine,State of','code'=>'275'),
'Panama'=>array('name'=>'Panama','code'=>'591'),
'Papua New Guinea'=>array('name'=>'Papua New Guinea','code'=>'598'),
'Paraguay'=>array('name'=>'Paraguay','code'=>'600'),
'Peru'=>array('name'=>'Peru','code'=>'604'),
'Philippines'=>array('name'=>'Philippines (the)','code'=>'608'),
'Pitcairn'=>array('name'=>'Pitcairnâ€Š[u]','code'=>'612'),
'Poland'=>array('name'=>'Poland','code'=>'616'),
'Portugal'=>array('name'=>'Portugal','code'=>'620'),
'Puerto Rico'=>array('name'=>'Puerto Rico','code'=>'630'),
'Qatar'=>array('name'=>'Qatar','code'=>'634'),
'Reunion'=>array('name'=>'RÃ©union','code'=>'638'),
'Romania'=>array('name'=>'Romania','code'=>'642'),
'Russian Federation (the)â€Š[v]'=>array('name'=>'Russian Federation (the)â€Š[v]','code'=>'643'),
'Rwanda'=>array('name'=>'Rwanda','code'=>'646'),
'Saint BarthÃ©lemy'=>array('name'=>'Saint BarthÃ©lemy','code'=>'652'),
'Saint Helena'=>array('name'=>'Saint Helena,Ascension and Tristan da Cunha','code'=>'654'),
'Saint Kitts and Nevis'=>array('name'=>'Saint Kitts and Nevis','code'=>'659'),
'Saint Lucia'=>array('name'=>'Saint Lucia','code'=>'662'),
'Saint Martin (French part)'=>array('name'=>'Saint Martin (French part)','code'=>'663'),
'Saint Pierre and Miquelon'=>array('name'=>'Saint Pierre and Miquelon','code'=>'666'),
'Saint Vincent and the Grenadines'=>array('name'=>'Saint Vincent and the Grenadines','code'=>'670'),
'Samoa'=>array('name'=>'Samoa','code'=>'882'),
'San Marino'=>array('name'=>'San Marino','code'=>'674'),
'Sao Tome and Principe'=>array('name'=>'Sao Tome and Principe','code'=>'678'),
'Saudi Arabia'=>array('name'=>'Saudi Arabia','code'=>'682'),
'Senegal'=>array('name'=>'Senegal','code'=>'686'),
'Serbia'=>array('name'=>'Serbia','code'=>'688'),
'Seychelles'=>array('name'=>'Seychelles','code'=>'690'),
'Sierra Leone'=>array('name'=>'Sierra Leone','code'=>'694'),
'Singapore'=>array('name'=>'Singapore','code'=>'702'),
'Sint Maarten (Dutch part)'=>array('name'=>'Sint Maarten (Dutch part)','code'=>'534'),
'Slovakia'=>array('name'=>'Slovakia','code'=>'703'),
'Slovenia'=>array('name'=>'Slovenia','code'=>'705'),
'Solomon Islands'=>array('name'=>'Solomon Islands','code'=>'90'),
'Somalia'=>array('name'=>'Somalia','code'=>'706'),
'South Africa'=>array('name'=>'South Africa','code'=>'710'),
'South Georgia and the South Sandwich Islands'=>array('name'=>'South Georgia and the South Sandwich Islands','code'=>'239'),
'South Sudan'=>array('name'=>'South Sudan','code'=>'728'),
'Spain'=>array('name'=>'Spain','code'=>'724'),
'Sri Lanka'=>array('name'=>'Sri Lanka','code'=>'144'),
'Sudan'=>array('name'=>'Sudan (the)','code'=>'729'),
'Suriname'=>array('name'=>'Suriname','code'=>'740'),
'Svalbard'=>array('name'=>'Svalbard','code'=>'744'),
'Sweden'=>array('name'=>'Sweden','code'=>'752'),
'Switzerland'=>array('name'=>'Switzerland','code'=>'756'),
'Syrian Arab Republic'=>array('name'=>'Syrian Arab Republic (the)â€Š[x]','code'=>'760'),
'Taiwan'=>array('name'=>'Taiwan (Province of China)â€Š[y]','code'=>'158'),
'Tajikistan'=>array('name'=>'Tajikistan','code'=>'762'),
'Tanzania'=>array('name'=>'Tanzania,the United Republic of','code'=>'834'),
'Thailand'=>array('name'=>'Thailand','code'=>'764'),
'East Timor'=>array('name'=>'Timor-Lesteâ€Š[aa]','code'=>'626'),
'Togo'=>array('name'=>'Togo','code'=>'768'),
'Tokelau'=>array('name'=>'Tokelau','code'=>'772'),
'Tonga'=>array('name'=>'Tonga','code'=>'776'),
'Trinidad and Tobago'=>array('name'=>'Trinidad and Tobago','code'=>'780'),
'Tunisia'=>array('name'=>'Tunisia','code'=>'788'),
'Turkey'=>array('name'=>'Turkey','code'=>'792'),
'Turkmenistan'=>array('name'=>'Turkmenistan','code'=>'795'),
'Turks and Caicos Islands (the)'=>array('name'=>'Turks and Caicos Islands (the)','code'=>'796'),
'Tuvalu'=>array('name'=>'Tuvalu','code'=>'798'),
'Uganda'=>array('name'=>'Uganda','code'=>'800'),
'Ukraine'=>array('name'=>'Ukraine','code'=>'804'),
'United Arab Emirates'=>array('name'=>'United Arab Emirates (the)','code'=>'784'),
'United Kingdom'=>array('name'=>'United Kingdom of Great Britain and Northern Ireland (the)','code'=>'826'),
'United States Minor Outlying Islands'=>array('name'=>'United States Minor Outlying Islands (the)â€Š[ac]','code'=>'581'),
'United States'=>array('name'=>'United States of America (the)','code'=>'840'),
'Uruguay'=>array('name'=>'Uruguay','code'=>'858'),
'Uzbekistan'=>array('name'=>'Uzbekistan','code'=>'860'),
	);
	
	const currencyArray = array(
	'AFA'=>array('name'=>'Afghanistan Afghani','code'=>'004'),
	'ALL'=>array('name'=>'Albanian Lek','code'=>'008'),
	'DZD'=>array('name'=>'Algerian Dinar','code'=>'012'),
	'USD'=>array('name'=>'US Dollar','code'=>'840'),
	'ESP'=>array('name'=>'Spanish Peseta','code'=>'724'),
	'FRF'=>array('name'=>'French Franc','code'=>'250'),
	'ADP'=>array('name'=>'Andorran Peseta','code'=>'020'),
	'AOA'=>array('name'=>'Kwanza','code'=>'973'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'ARS'=>array('name'=>'Argentine Peso','code'=>'032'),
	'AMD'=>array('name'=>'Armenian Dram','code'=>'051'),
	'AWG'=>array('name'=>'Aruban Guilder','code'=>'533'),
	'AUD'=>array('name'=>'Australian Dollar','code'=>'036'),
	'ATS'=>array('name'=>'Austrian Schilling','code'=>'040'),
	'AZM'=>array('name'=>'Azerbaijanian Manat','code'=>'031'),
	'BSD'=>array('name'=>'Bahamian Dollar','code'=>'044'),
	'BHD'=>array('name'=>'Bahraini Dinar','code'=>'048'),
	'BDT'=>array('name'=>'Bangladeshi Taka','code'=>'050'),
	'BBD'=>array('name'=>'Barbados Dollar','code'=>'052'),
	'BYB'=>array('name'=>'Belarussian Ruble','code'=>'112'),
	'RYR'=>array('name'=>'Belarussian Ruble','code'=>'974'),
	'BEF'=>array('name'=>'Belgian Franc','code'=>'056'),
	'BZD'=>array('name'=>'Belize Dollar','code'=>'084'),
	'XOF'=>array('name'=>'CFA Franc (BCEAO)','code'=>'952'),
	'BMD'=>array('name'=>'Bermuda Dollar','code'=>'060'),
	'INR'=>array('name'=>'Indian Rupee','code'=>'356'),
	'BTN'=>array('name'=>'Ngultrum','code'=>'064'),
	'BOB'=>array('name'=>'Boliviano','code'=>'068'),
	'BOV'=>array('name'=>'Mvdol','code'=>'984'),
	'BAM'=>array('name'=>'Convertible Marks','code'=>'977'),
	'BWP'=>array('name'=>'Pula','code'=>'072'),
	'NOK'=>array('name'=>'Norwegian Krone','code'=>'578'),
	'BRL'=>array('name'=>'Brazil Real','code'=>'986'),	
	'BND'=>array('name'=>'Brunei Dollar','code'=>'096'),
	'BGL'=>array('name'=>'Lev','code'=>'100'),
	'BGN'=>array('name'=>'Bulgarian Lev','code'=>'975'),	
	'BIF'=>array('name'=>'Burundi Franc','code'=>'108'),
	'KHR'=>array('name'=>'Cambodian Riel','code'=>'116'),
	'XAF'=>array('name'=>'CFA Franc (BEAC)','code'=>'950'),
	'CAD'=>array('name'=>'Canadian Dollar','code'=>'124'),
	'CVE'=>array('name'=>'Cape Verde Escudo','code'=>'132'),
	'KYD'=>array('name'=>'Cayman Islands Dollar','code'=>'136'),
	'XAF'=>array('name'=>'CFA Franc (BEAC)','code'=>'950'),
	'XAF'=>array('name'=>'CFA Franc (BEAC)','code'=>'950'),
	'CLP'=>array('name'=>'Chilean Peso','code'=>'152'),
	'CLF'=>array('name'=>'Unidates de fomento','code'=>'990'),
	'CNY'=>array('name'=>'Yuan Renminbi','code'=>'156'),
	'HKD'=>array('name'=>'Hong Kong Dollar','code'=>'344'),
	'MOP'=>array('name'=>'Pataca','code'=>'446'),	
	'COP'=>array('name'=>'Colombian Peso','code'=>'170'),
	'KMF'=>array('name'=>'Comoro Franc','code'=>'174'),
	'XAF'=>array('name'=>'CFA Franc (BEAC)','code'=>'950'),
	'CDF'=>array('name'=>'Franc Congolais','code'=>'976'),
	'NZD'=>array('name'=>'New Zealand Dollar','code'=>'554'),
	'CRC'=>array('name'=>'Costa Rican Colon','code'=>'188'),	
	'HRK'=>array('name'=>'Croatian Kuna','code'=>'191'),
	'CUP'=>array('name'=>'Cuban Peso','code'=>'192'),
	'CYP'=>array('name'=>'Cyprus Pound','code'=>'196'),
	'CZK'=>array('name'=>'Czech Koruna','code'=>'203'),
	'DKK'=>array('name'=>'Danish Krone','code'=>'208'),
	'DJF'=>array('name'=>'Djibouti Franc','code'=>'262'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'DOP'=>array('name'=>'Dominican Peso','code'=>'214'),
	'TPE'=>array('name'=>'Timor Escudo','code'=>'626'),
	'IDE'=>array('name'=>'Rupiah','code'=>'360'),
	'ECS'=>array('name'=>'Sucre','code'=>'218'),
	'ECV'=>array('name'=>'Unidad de Valor Constante (UVC)','code'=>'983'),
	'EGP'=>array('name'=>'Egyptian Pound','code'=>'818'),
	'SVC'=>array('name'=>'El Salvador Colon','code'=>'222'),
	'XAF'=>array('name'=>'CFA Franc (BEAC)','code'=>'950'),
	'ERN'=>array('name'=>'Nafka','code'=>'232'),
	'EEK'=>array('name'=>'Kroon','code'=>'233'),
	'ETB'=>array('name'=>'Ethiopian Birr','code'=>'230'),
	'DKK'=>array('name'=>'Danish Krone','code'=>'208'),
	'XEU'=>array('name'=>'euro','code'=>'954'),
	'EUR'=>array('name'=>'European Currency Unit','code'=>'978'),
	'FKP'=>array('name'=>'Falkland Islands Pound','code'=>'238'),
	'FJD'=>array('name'=>'Fiji Dollar','code'=>'242'),
	'FIM'=>array('name'=>'Finnish Markka','code'=>'246'),
	'FRF'=>array('name'=>'French Franc','code'=>'250'),
	'FRF'=>array('name'=>'French Franc','code'=>'250'),
	'XPF'=>array('name'=>'CFP Franc','code'=>'953'),
	'XPF'=>array('name'=>'CFP Franc','code'=>'953'),
	'XAF'=>array('name'=>'CFA Franc (BEAC)','code'=>'950'),
	'GMD'=>array('name'=>'Dalasi','code'=>'270'),
	'GEL'=>array('name'=>'Lari','code'=>'981'),
	'DEM'=>array('name'=>'Deutsche Mark','code'=>'276'),
	'GHC'=>array('name'=>'Ghana Cedi','code'=>'288'),
	'GIP'=>array('name'=>'Gibraltar Pound','code'=>'292'),
	'GRD'=>array('name'=>'Drachma','code'=>'300'),
	'DKK'=>array('name'=>'Danish Krone','code'=>'208'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'FRF'=>array('name'=>'French Franc','code'=>'250'),	
	'GTQ'=>array('name'=>'Guatemalan Quetzal','code'=>'320'),
	'GNF'=>array('name'=>'Guinea Franc','code'=>'324'),
	'GWP'=>array('name'=>'Guinea-Bissau Peso','code'=>'624'),	
	'GYD'=>array('name'=>'Guyana Dollar','code'=>'328'),
	'HTG'=>array('name'=>'Haiti Gourde','code'=>'332'),		
	'ITL'=>array('name'=>'Italian Lira','code'=>'380'),
	'HNL'=>array('name'=>'Honduran Lempira','code'=>'340'),
	'HUF'=>array('name'=>'Forint','code'=>'348'),
	'ISK'=>array('name'=>'Iceland Krona','code'=>'352'),	
	'IDR'=>array('name'=>'Indonesian Rupiah','code'=>'360'),
	'XDR'=>array('name'=>'SDR','code'=>'960'),
	'IRR'=>array('name'=>'Iranian Rial','code'=>'364'),
	'IQD'=>array('name'=>'Iraqi Dinar','code'=>'368'),
	'IEP'=>array('name'=>'Irish Pound','code'=>'372'),
	'ILS'=>array('name'=>'New Israeli Sheqel','code'=>'376'),
	'ITL'=>array('name'=>'Italian Lira','code'=>'380'),
	'JMD'=>array('name'=>'Jamaican Dollar','code'=>'388'),
	'JPY'=>array('name'=>'Yen','code'=>'392'),
	'JOD'=>array('name'=>'Jordanian Dinar','code'=>'400'),
	'KZT'=>array('name'=>'Kazakhstan Tenge','code'=>'398'),
	'KES'=>array('name'=>'Kenyan Shilling','code'=>'404'),	
	'KPW'=>array('name'=>'North Korean Won','code'=>'408'),
	'KRW'=>array('name'=>'South Korean Won','code'=>'410'),
	'KWD'=>array('name'=>'Kuwaiti Dinar','code'=>'414'),
	'KGS'=>array('name'=>'Kyrgyzstan Som','code'=>'417'),
	'LAK'=>array('name'=>'Laos Kip','code'=>'418'),
	'LVL'=>array('name'=>'Latvian Lats','code'=>'428'),
	'LBP'=>array('name'=>'Lebanese Pound','code'=>'422'),
	'ZAR'=>array('name'=>'Rand','code'=>'710'),
	'LSL'=>array('name'=>'Loti','code'=>'426'),
	'LRD'=>array('name'=>'Liberian Dollar','code'=>'430'),
	'LYD'=>array('name'=>'Libyan Dinar','code'=>'434'),
	'CHF'=>array('name'=>'Swiss Franc','code'=>'756'),
	'LTL'=>array('name'=>'Lithuanian Litas','code'=>'440'),
	'LUF'=>array('name'=>'Luxembourg Franc','code'=>'442'),
	'MKD'=>array('name'=>'Macedonian Denar','code'=>'807'),
	'MGF'=>array('name'=>'Malagasy Franc','code'=>'450'),
	'MWK'=>array('name'=>'Kwacha','code'=>'454'),
	'MYR'=>array('name'=>'Malaysian Ringgit','code'=>'458'),
	'MVR'=>array('name'=>'Maldives Rufiyaa','code'=>'462'),	
	'MTL'=>array('name'=>'Maltese Lira','code'=>'470'),	
	'FRF'=>array('name'=>'French Franc','code'=>'250'),
	'MRO'=>array('name'=>'Mauritanian Ouguiya','code'=>'478'),
	'MUR'=>array('name'=>'Mauritius Rupee','code'=>'480'),
	'MXN'=>array('name'=>'Mexican Peso','code'=>'484'),
	'MXV'=>array('name'=>'Mexican Unidad de Inversion (UDI)','code'=>'979'),	
	'MDL'=>array('name'=>'Moldovan Leu','code'=>'498'),
	'FRF'=>array('name'=>'French Franc','code'=>'250'),
	'MNT'=>array('name'=>'Mongolian Tugrik','code'=>'496'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'MAD'=>array('name'=>'Moroccan Dirham','code'=>'504'),
	'MZM'=>array('name'=>'Mozambique Metical','code'=>'508'),
	'MMK'=>array('name'=>'Myanmar Kyat','code'=>'104'),
	'ZAR'=>array('name'=>'Rand','code'=>'710'),
	'NAD'=>array('name'=>'Namibia Dollar','code'=>'516'),	
	'NPR'=>array('name'=>'Nepalese Rupee','code'=>'524'),
	'ANG'=>array('name'=>'Netherlands Antillian Guilder','code'=>'532'),
	'NLG'=>array('name'=>'Netherlands Gulder','code'=>'528'),
	'XPF'=>array('name'=>'CFP Franc','code'=>'953'),
	'NZD'=>array('name'=>'New Zealand Dollar','code'=>'554'),
	'NIO'=>array('name'=>'Nicaraguan Cordoba Oro','code'=>'558'),	
	'NGN'=>array('name'=>'Nigerian Naira','code'=>'566'),
	'NZD'=>array('name'=>'New Zealand Dollar','code'=>'554'),	
	'NOK'=>array('name'=>'Norwegian Krone','code'=>'578'),
	'OMR'=>array('name'=>'Rial Omani','code'=>'512'),
	'PKR'=>array('name'=>'Pakistan Rupee','code'=>'586'),	
	'PAB'=>array('name'=>'Balboa','code'=>'590'),
	'PGK'=>array('name'=>'Papua New Guinea Kina','code'=>'598'),
	'PYG'=>array('name'=>'Paraguay Guarani','code'=>'600'),
	'PEN'=>array('name'=>'Peru Nuevo Sol','code'=>'604'),
	'PHP'=>array('name'=>'Philippine Peso','code'=>'608'),
	'NZD'=>array('name'=>'New Zealand Dollar','code'=>'554'),
	'PLN'=>array('name'=>'Poland Zloty','code'=>'985'),
	'PTE'=>array('name'=>'Portuguese Escudo','code'=>'620'),
	'USD'=>array('name'=>'US Dollar','code'=>'840'),
	'QAR'=>array('name'=>'Qatari Rial','code'=>'634'),
	'FRF'=>array('name'=>'French Franc','code'=>'250'),
	'RON'=>array('name'=>'Romanian Leu','code'=>'642'),
	'RUR'=>array('name'=>'Russian Ruble','code'=>'810'),
	'RUB'=>array('name'=>'Russian Ruble','code'=>'643'),
	'RWF'=>array('name'=>'Rwanda Franc','code'=>'646'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'FRF'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'XCD'=>array('name'=>'French Franc','code'=>'250'),
	'XCD'=>array('name'=>'East Caribbean Dollar','code'=>'951'),
	'SHP'=>array('name'=>'St. Helena Pound','code'=>'654'),
	'WST'=>array('name'=>'Tala','code'=>'882'),
	'ITL'=>array('name'=>'Italian Lira','code'=>'380'),
	'STD'=>array('name'=>'Sao Tome and Principe Dobra','code'=>'678'),
	'SAR'=>array('name'=>'Saudi Riyal','code'=>'682'),	
	'SCR'=>array('name'=>'Seychelles Rupee','code'=>'690'),
	'SLL'=>array('name'=>'Sierra Leone Leone','code'=>'694'),
	'SGD'=>array('name'=>'Singapore Dollar','code'=>'702'),
	'SKK'=>array('name'=>'Slovak Koruna','code'=>'703'),
	'SIT'=>array('name'=>'Slovenia Tolar','code'=>'705'),
	'SBD'=>array('name'=>'Solomon Islands Dollar','code'=>'90'),
	'SOS'=>array('name'=>'Somalia Shilling','code'=>'706'),
	'ZAR'=>array('name'=>'South African Rand','code'=>'710'),
	'ESP'=>array('name'=>'Spanish Peseta','code'=>'724'),
	'LKR'=>array('name'=>'Sri Lanka Rupee','code'=>'144'),
	'SDP'=>array('name'=>'Sudanese Dinar','code'=>'736'),
	'SRG'=>array('name'=>'Suriname Guilder','code'=>'740'),
	'NOK'=>array('name'=>'Norwegian Krone','code'=>'578'),
	'SZL'=>array('name'=>'Swaziland Lilangeni','code'=>'748'),
	'SEK'=>array('name'=>'Swedish Krona','code'=>'752'),
	'CHF'=>array('name'=>'Swiss Franc','code'=>'756'),
	'SYP'=>array('name'=>'Syrian Pound','code'=>'760'),
	'TWD'=>array('name'=>'New Taiwan Dollar','code'=>'901'),
	'TJR'=>array('name'=>'Tajik Ruble','code'=>'762'),
	'TZS'=>array('name'=>'Tanzanian Shilling','code'=>'834'),
	'THB'=>array('name'=>'Thai Baht','code'=>'764'),	
	'NZD'=>array('name'=>'New Zealand Dollar','code'=>'554'),
	'TOP'=>array('name'=>'Tonga Paanga','code'=>'776'),
	'TTD'=>array('name'=>'Trinidad and Tobago Dollar','code'=>'780'),
	'TND'=>array('name'=>'Tunisian Dinar','code'=>'788'),
	'TRL'=>array('name'=>'Turkish Lira','code'=>'792'),
	'TMM'=>array('name'=>'Manat','code'=>'795'),		
	'UGX'=>array('name'=>'Ugandan Shilling','code'=>'800'),
	'UAH'=>array('name'=>'Hryvnia','code'=>'980'),
	'AED'=>array('name'=>'UAE Dirham','code'=>'784'),
	'GBP'=>array('name'=>'Pound Sterling','code'=>'826'),
	'UYU'=>array('name'=>'Peso Uruguayo','code'=>'858'),
	'UZS'=>array('name'=>'Uzbekistan Sum','code'=>'860'),
	'VUV'=>array('name'=>'Vanuatu Vatu','code'=>'548'),
	'VEB'=>array('name'=>'Venezuela Bolivar','code'=>'862'),
	'VND'=>array('name'=>'Viet Nam Dong','code'=>'704'),	
	'XPF'=>array('name'=>'CFP Franc','code'=>'953'),
	'MAD'=>array('name'=>'Moroccan Dirham','code'=>'504'),
	'YER'=>array('name'=>'Yemeni Rial','code'=>'886'),
	'YUN'=>array('name'=>'Yugoslavian Dinar','code'=>'891'),
	'ZRN'=>array('name'=>'Unknown','code'=>'180'),
	'ZMK'=>array('name'=>'Zambia Kwacha','code'=>'894'),
	'ZWD'=>array('name'=>'Zimbabwe Dollar','code'=>'716')	
	);
   public function pay($request){
       if(Session::has('payment_type')){
           if(Session::get('payment_type') == 'cart_payment'){
               $order = Order::findOrFail(Session::get('order_id'));

               if(BusinessSetting::where('type', 'benefit_sandbox')->first()->value == 1){
                   // testing_url
                   $endPoint = 'https://www.test.benefit-gateway.bh/payment/PaymentHTTP.htm?param=paymentInit';
               }
               else{
                   // live_url
                   $endPoint = 'https://www.benefit-gateway.bh/payment/PaymentHTTP.htm?param=paymentInit';
               }
                $order = Order::findOrFail(Session::get('order_id'));
       
              //$redirect_url='https://suqbahrain.com/benefit/done/?wc-api=1';
			  $redirect_url='https://suqbahrain.com/benefit/notify.php';
      
               //$error_url='https://suqbahrain.com/benefit/fail/?wc-api=1';
			   //$error_url= 'https://suqbahrain.com/benefit/thankyou.php';
			   $error_url='https://suqbahrain.com/benefit/fail/';
                $order = Order::findOrFail(Session::get('order_id'));
               $transportalId= env('BENEFIT_TRANSPORTAL_ID');
        
               $transportalPass=env('BENEFIT_TRANSPORTAL_PASSWORD');
               $terminialKey=env('BENEFIT_TERMINAL_KEY');
               $currency='USD';
              $email= Session::get('shipping_info')['email'];
      
              $firstname=Session::get('shipping_info')['name'];
         $phone=Session::get('shipping_info')['phone'];
               $baddress = Session::get('shipping_info')['address'];
               $saddress =$baddress;
                                                         
               $country= self::countryArray[Session::get('shipping_info')['country']];
    
      
          
               $currency = self::currencyArray['KWD'];	
               $order_id=Session::get('order_id');
               $order_id = $order_id.'_'.date("ymd");
            //$roder_total=convert_to_usd($order->grand_total);
            $roder_total=$order->grand_total;
            //requesting
            $roder_total=round($roder_total,2);
            $ReqAction = "action=1&"; //Purchase only
		     $ReqAmount = "amt=".$roder_total."&";
		     $ReqTrackId = "trackid=".$order_id."&";
		     $ReqTranportalId = "id=".$transportalId."&";
		     $ReqTranportalPassword = "password=".$transportalPass."&";
            $ReqCurrency = "currencycode=048&";
            $ReqLangid = "langid=USA&";
            
           
		$Reqship_To_Postalcd = "ship_To_Postalcd=".Session::get('shipping_info')['postal_code']."&";
		$Reqship_To_Address = "ship_To_Address=".$saddress."&";
		$Reqship_To_LastName = "ship_To_LastName=".$firstname."&";
		$Reqship_To_FirstName = "ship_To_FirstName=".$firstname."&";
		$Reqship_To_Phn_Num = "ship_To_Phn_Num=".$phone."&";
		$Reqship_To_CountryCd = "ship_To_CountryCd=048&";//.$country['code']."&"; 
	
		$Reqcard_PostalCd = "card_PostalCd=".Session::get('shipping_info')['postal_code']."&";
		$Reqcard_Address = "card_Address=".$baddress."&";
		$Reqcard_Phn_Num = "card_Phn_Num=".$phone."&";
		$Reqcust_email = "cust_email=".$email."&";
		
		$ReqResponseUrl = "&responseURL=".$redirect_url."&";
		$ReqErrorUrl = "&errorURL=".$error_url."&";
	
	
	
		$ReqUdf1 = "udf1=Test1&";	// UDF1 values 
		$ReqUdf2 = "udf2="."Test2"."&";	// UDF2 values 
		$ReqUdf3 = "udf3="."Test3"."&";	// UDF3 values 
		$ReqUdf5 = "udf5="."Test5"."&"; // UDF5 values to be set with udf4 values of configuration
		
		$ReqUdf4 = "udf4="."WooCommerce3.6.1_Wordpress5.1.1_PHP7.2&";	// UDF4 is a fixed value for tracking
				
	$TranRequest=$ReqAmount.$ReqAction.$ReqResponseUrl.$ReqErrorUrl.$ReqTrackId.$ReqCurrency.$ReqLangid.$ReqTranportalId.$ReqTranportalPassword.$Reqship_To_Postalcd.$Reqship_To_Address.$Reqship_To_LastName.$Reqship_To_FirstName.$Reqship_To_Phn_Num.$Reqship_To_CountryCd.$Reqcard_PostalCd.
		$Reqcard_Address.$Reqcard_Phn_Num.$Reqcust_email.$ReqUdf1.$ReqUdf2.$ReqUdf3.$ReqUdf4.$ReqUdf5;
	
		//echo  $TranRequest ;		 
		$req='';
		$req = "&trandata=".$this->encryptAES($TranRequest,$terminialKey);
		
     
		$req = $req.$ReqErrorUrl.$ReqResponseUrl."&tranportalId=".$transportalId;
		$redirectUrl=$endPoint.$req;
	//		var_dump(	$redirectUrl   );
      // die;
		return Redirect::to( $redirectUrl );
     
           }
       }
       
	
 }

//encrypt

function encryptAES($str,$key) {		
		$str = $this->pkcs5_pad($str); 
		$encrypted = openssl_encrypt($str, $this->AES_METHOD, $key, OPENSSL_ZERO_PADDING, $this->AES_IV);
		$encrypted = base64_decode($encrypted);
		$encrypted = unpack('C*', ($encrypted));
		$encrypted = $this->byteArray2Hex($encrypted);
		$encrypted = urlencode($encrypted);
		return $encrypted;
	}
//dycrypt

function decryptAES($code,$key) { 		
		$code = $this->hex2ByteArray(trim($code));
		$code= $this->byteArray2String($code);	  
		$code = base64_encode($code);
		$decrypted = openssl_decrypt($code, $this->AES_METHOD, $key, OPENSSL_ZERO_PADDING, $this->AES_IV);
		return $this->pkcs5_unpad($decrypted);
	}
//packs
function pkcs5_pad ($text) {
		$blocksize = openssl_cipher_iv_length($this->AES_METHOD);
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}
//upack
function pkcs5_unpad($text) {
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)) {
			return false;	
		}
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
			return false;
		}
		return substr($text, 0, -1 * $pad);
    }
//
function byteArray2Hex($byteArray) {
		$chars = array_map("chr", $byteArray);
		$bin = join($chars);
		return bin2hex($bin);
	}
	
	function hex2ByteArray($hexString) {
		$string = hex2bin($hexString);
		return unpack('C*', $string);
	}
	
	function byteArray2String($byteArray) {
		$chars = array_map("chr", $byteArray);
		return join($chars);
	}
	
	// TDES Functions start
	function encryptTDES($payload, $key) {  
		$chiper = "des-ede3";  //Algorthim used to encrypt
		if((strlen($payload)%8)!=0) {
			//Perform right padding
			$payload = $this->rightPadZeros($payload);
		}
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
		$encrypted = openssl_encrypt($payload, $chiper, $key,OPENSSL_RAW_DATA,$iv);
		
		$encrypted=unpack('C*', ($encrypted));
		$encrypted=$this->byteArray2Hex($encrypted);
		return strtoupper($encrypted);  
	}
	//decrypt tdes
	function decryptTDES($data, $key) {
		$chiper = "des-ede3";  //Algorthim used to decrypt
		$data = $this->hex2ByteArray($data);
		$data = $this->byteArray2String($data);
		$data = base64_encode($data);
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
		$decrypted = openssl_decrypt($data, $chiper, $key, OPENSSL_ZERO_PADDING,$iv);
		return $decrypted;
	} 
	//padzerors
	function rightPadZeros($Str) {
		if(null == $Str){
			return null;
		}
		$PadStr = $Str;
		
		for ($i = strlen($Str);($i%8)!=0; $i++) {
			$PadStr .= "^";
		}
		return $PadStr;
	}



   public function fail(Request $request)
    {
		if(isset($_POST['trandata']) && !empty($_POST['trandata'])){
			$terminialKey=env('BENEFIT_TERMINAL_KEY');
			$terminialKey	= '11630213913211630213913211630213';
			$decrytedData=$this->decryptAES($_POST['trandata'],$terminialKey);
			
			$res='';
			parse_str($decrytedData,$res);
			
			$ResResult = $res['result'];
			
			if (isset($ResResult) && strtoupper($ResResult) == 'CAPTURED') {
				flash(__('Order has been placed successfully!'))->success();
				return redirect()->route('home');
			} else{
				flash(__("we're unable to complete your transaction at this time, please try again later!"))->success();
				return redirect()->route('home');
			}
			
			//echo 'res<pre>';print_r($res);
		}
		//echo 'pos<pre>';print_r($_POST);exit;
		flash(__('We have received you order and it will be confirmed shortly!'))->success();
		return redirect()->route('home');
         /*$ResErrorText=$request->get('ErrorText');
         $ResPaymentId=$request->get('PaymentID');
           $ResWcApi=$request->get('wc-api');
         
        //$request->session()->forget('order_id');
        //$request->session()->forget('payment_data');
        flash(__('Error'.$ResWcApi.$ResPaymentId.$ResErrorText))->success();
     // echo " Failed to payment";
       die;
        	return Redirect::to( 'https://suqbahrain.com/' );*/
    }
    // success
    
    
    public function done(Request $request)
    {
        
     // return Redirect::to( 'https://suqbahrain.com/' ); 
      echo "Thank for your payment";
      // flash("We Reveived your Payment")->success();
       //$decrytedData=$this->decryptAES($ResTranData,$this->termresourcekey);
    }


}
