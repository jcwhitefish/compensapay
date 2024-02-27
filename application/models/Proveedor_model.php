<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class Proveedor_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Guarda el resgistro de un nuevo proveedor
	 *
	 *
	 * @return void
	 * @author  Fernando Alarcon <fernando_alarcon_r@hotmail.com>.
	 * @version 1.0.0
	 */
	public function registrarProveedor (array $args, ?string $env = 'SANDBOX'){
		
		$queryupd = "UPDATE companies set legal_name ='{$args['bussinesName']}', short_name = '{$args['nameComercial']}', rfc = '{$args['rfc']}', address = '{$args['dom']}', telephone ='{$args['phoneForm']}', account_clabe = '{$args['clabe']}' where id = {$args['companie']} ";
		if ($result = $this->db->query($queryupd)){
			
			$query = "INSERT INTO rec_supplier (id_com, nationality, date_const, num_rpc, e_firma, e_mail, website, obj_social, desc_operation, transact_month, ammount, person_incharge, person_name, person_curp, person_rfc, person_id, person_adress, person_email, person_phone, natural_person_benef, benef_legal_entity, license_services, supervisor_name, license_type, license_date, been_audited, anticorruption, data_protection, vul_activity, regist_sat, up_to_date) 
            VALUES ({$args['companie']}, '{$args['nationality']}', '{$args['dateConst']}','{$args['folio']}', '{$args['efirma']}', '{$args['emailForm']}', '{$args['web']}', '{$args['socialobj']}', '{$args['descOperation']}', '{$args['transactMonth']}', '{$args['amount']}', '{$args['charge']}', '{$args['nameForm2']}', '{$args['curp']}', '{$args['rfcForm2']}', '{$args['idNumber']}', '{$args['domForm2']}', '{$args['emailForm2']}', '{$args['phoneForm2']}', {$args['fisica']}, {$args['moral']}, {$args['license']}, '{$args['supervisor']}', '{$args['typeLicense']}', '{$args['dateAward']}', {$args['audited']}, {$args['anticorruption']}, {$args['dataProtection']}, {$args['vulnerable']}, '{$args['servTrib']}', '{$args['obligations']}')";
			if ($result = $this->db->query($query)){
				$id = $this->db->insert_id();
				return ['id'=>$id];
				
			}else{
				return ($result->error());
			}

		}else{
			return ($result->error());
		}

		
	}

	public function createPDF (array $args, ?string $env = 'SANDBOX'){
		$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
		$mpdf->SetHTMLHeader('');

		$inputSi = '<p>Si<input type="radio" name="fisica" checked="checked">&nbsp;&nbsp;&nbsp;No<input type="radio" name="fisica"></p>';
		$inputNo = '<p>Si<input type="radio" name="fisica">&nbsp;&nbsp;&nbsp;No<input type="radio" name="fisica" checked="checked"></p>';

		$mpdf->SetHTMLFooter('<div class="container">
								<table>
									<tr>
										<td style="width:70%" class="alignJustify"><p class="smallFont">CONFIDENCIAL<br>Cuenca Tecnología Financiera, S.A. de C.V., Institución de Fondos de Pago Electrónico</p></td>
										<td style="text-align: right;" class="smallFont">{PAGENO}</td>
									</tr>
								</table>
							</div>');
		$bodyHtml = '<html lang="es-MX">
                            <head>
                                <style>
                                    .align-center{
                                      text-align: center;
                                      padding: 1px;
                                    }

                                    .alignJustify{
                                      text-align: justify;
                                    }
                                    
                                    .inter{
                                        line-height: 15px;
                                    }
                                    
                                    .margenes{
                                        padding-left: 10px;
                                        padding-right: 10px;
                                    }
                                    
                                    .bodyTbl:after, .headTbl:after,.row:after {
                                      content: "";
                                      display: table;
                                      clear: both;
                                    }
									
									.bigFont{
                                        font-size: 1.1em;
                                    }

                                    .medFont{
                                        font-size: .9em;
                                    }

                                    .smallFont{
                                    	color: #aba6b2;
                                        font-size: .7em;
                                    }

                                    .half{
                                    	width: 50%;
                                    	border: 1px solid #000;
                                    	padding: 5px;
                                    }

                                    .complete{
                                    	width: 100%;
                                    	border: 1px solid #000;
                                    	padding: 10px;
                                    }

                                    .borders{
                                    	border-collapse: collapse;
                                    	width: 100%;
                                    }

                                    .pageBreak{
                                    	page-break-before: always;
                                    }

                                    .content{
                                    	height: 100px;
                                    }

                                    .alignRight{
                                    	margin-left: 100px;
                                    }
                                    
                                    body{
                                        font-family: "Arial";
                                        margin: 0px;
                                        padding: 0;
                                    }

                                    .80{
                                    	width: 80%;
                                    	border: 1px solid #000;
                                    	padding: 5px;
                                    }

                                    .20{
                                    	width: 20%;
                                    	border: 1px solid #000;
                                    	padding: 5px;
                                    }

                                    .container{
                                    	margin: 40px;

                                    }
                                </style>
                            </head>
                        <body>
                        	<div class="container">
		                        <div class="align-center">
		                        	<p class="bigFont">FORMATO PARA LA APERTURA DE CUENTA DE FONDOS DE PAGO <br>ELECTRÓNICO <br>PERSONAS MORALES</p>
		                        </div>
		                        <div>
		                        	<p class="medFont">Aviso de Privacidad</p>
		                        	
		                        	<p class="medFont alignJustify">Cuenca Tecnología Financiera, S.A. de C.V., Institución de Fondos de Pago Electrónico y las
										sociedades pertenecientes al grupo Cuenca utilizarán cualquier dato personal expuesto en
										el presente documento, única y exclusivamente para la apertura de una cuenta de fondos
										de pago electrónico, cuestiones administrativas, de comunicación, de soporte a clientes, de
										atención a autoridades, o bien para las finalidades expresadas en cada asunto en concreto,
										esto en cumplimiento con la Ley Federal de Protección de Datos Personales en Posesión de
										los Particulares. Para mayor información acerca del tratamiento y de los derechos que
										puede hacer valer, usted puede acceder a nuestro aviso de privacidad integral a través de
										nuestra página de internet: <u>cuenca.com</u></p>

									<p>La información contenida en este documento es privada y confidencial.</p>
									<div style="text-align: right; width:80%">
										<img width="150" height="80" src="'. $args['formato'] .';base64,'. $args['firma'] .'">
									</div>
									<p>Firma del representante legal: _________________________________________________________</p>
									<p>A. Información general</p>
									<table class="borders">
										<tbody>
											<tr>
												<td class="half alignJustify">Denominación o razón social</td>
												<td class="half alignJustify">'.$args['bussinesName'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Nombre comercial</td>
												<td class="half alignJustify">'.$args['nameComercial'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Nacionalidad</td>
												<td class="half alignJustify">'.$args['nationality'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Fecha de constitución</td>
												<td class="half alignJustify">'.$args['dateConstPdf'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Número de folio en el Registro Público de Comercio o su equivalente</td>
												<td class="half alignJustify">'.$args['folio'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">RFC o su equivalente</td>
												<td class="half alignJustify">'.$args['rfc'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Número de certificado de firma electrónica (e firma) o su equivalente</td>
												<td class="half alignJustify">'.$args['efirma'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Domicilio fiscal</td>
												<td class="half alignJustify">'.$args['dom'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Número de teléfono</td>
												<td class="half alignJustify">'.$args['phoneForm'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Correo electrónico</td>
												<td class="half alignJustify">'.$args['emailForm'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Sitio web</td>
												<td class="half alignJustify">'.$args['web'].'</td>
											</tr>
											<tr>
												<td class="half alignJustify">Número de cuenta, CLABE y nombre de la entidad financiera distinta a Cuenca donde se tenga aperturada una cuenta de depósito (en caso de contar con ella)</td>
												<td class="half alignJustify">'.$args['clabe'].'</td>
											</tr>
										</tbody>
									</table>
		                        </div>
	                        </div>
							<div class="container pageBreak">
								<p>B. Modelo de negocio</p>
								<table class="borders">
									<tbody>
										<tr>
											<td class="complete alignJustify">Objeto social</td>
										</tr>
										<tr>
											<td class="complete alignJustify content">'.$args['socialobj'].'</td>
										</tr>
										<tr>
											<td class="complete alignJustify">Describa cómo utilizará la cuenta de fondos de pago electrónico para su operación</td>
										</tr>
										<tr>
											<td class="complete alignJustify content">'.$args['descOperation'].'</td>
										</tr>
									</tbody>
								</table>
								<p>C. Perfil transaccional</p>
								<table class="borders">
									<tbody>
										<tr>
											<td class="half alignJustify">Número estimado de transacciones por mes</td>
											<td class="half alignJustify">'.$args['transactMonth'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Monto promedio de transacción (MXN o USD)</td>
											<td class="half alignJustify">'.$args['amount'].'</td>
										</tr>											
									</tbody>
								</table>
								<p>D. Administración y representación legal</p>
								<p class="alignJustify">Por favor, provea la información relativa a los representantes legales, administración y principales funcionarios de la sociedad.</p>
								<table class="borders">
									<tbody>
										<tr>
											<td class="half alignJustify">Cargo</td>
											<td class="half alignJustify">'.$args['charge'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Nombre completo</td>
											<td class="half alignJustify">'.$args['nameForm2'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">CURP</td>
											<td class="half alignJustify">'.$args['curp'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">RFC</td>
											<td class="half alignJustify">'.$args['rfcForm2'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Tipo y número de identificación oficial</td>
											<td class="half alignJustify">'.$args['idNumber'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Domicilio</td>
											<td class="half alignJustify">'.$args['domForm2'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Correo electrónico</td>
											<td class="half alignJustify">'.$args['emailForm2'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Número de teléfono</td>
											<td class="half alignJustify">'.$args['phoneForm2'].'</td>
										</tr>
									</tbody>
								</table>
							
							</div>
							<div class=" containerpageBreak">
								<p>E. Beneficiarios controladores</p>
								<p class="alignJustify">¿Existe alguna persona que directa o indirectamente ejerza control* o tenga la titularidad del 25% o más de las acciones o partes sociales de la empresa?</p>
								'.($args['fisica'] == "1" ? $inputSi : $inputNo).'
								<div class="alignRight">
									<p class="alignJustify">*Control: Se entiende que una persona o grupo de personas controla a una persona moral cuando, a través de la titularidad de valores, por contrato o de cualquier otro acto, puede:<br>i) Imponer, directa o indirectamente, decisiones en las asambleas generales de accionistas, socios u órganos equivalentes, o nombrar o destituir a la mayoría de los consejeros, administradores o sus equivalentes;<br>ii) Mantener la titularidad de los derechos que permitan, directa o indirectamente, ejercer el voto respecto de más del cincuenta por ciento del capital social, o<br>iii) Dirigir, directa o indirectamente, la administración, la estrategia o las principales políticas de la misma.</p>
								</div>

								<p>¿Existe alguna persona moral que directa o indirectamente ejerza control o tenga la titularidad del 25% o más de las acciones o partes sociales de la empresa?</p>
								'. ($args['moral'] == "1" ? $inputSi : $inputNo).'
								<p><u>Favor de anexar al presente documento la estructura accionaria o del capital social de la persona moral.</u></p>

								<p>F. Estatus regulatorio y mejores prácticas</p>
								<p>¿La empresa requiere licencia, permiso o registro para la prestación de sus servicios?</p>
								'.($args['license'] == "1" ? $inputSi : $inputNo).'

								<p>En caso afirmativo, indicar la información siguiente:</p>
								<table class="borders">
									<tbody>
										<tr>
											<td class="half alignJustify">Nombre de la autoridad supervisora</td>
											<td class="half alignJustify">'.$args['supervisor'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Tipo de permiso, licencia o registro</td>
											<td class="half alignJustify">'.$args['typeLicense'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">Fecha en que fue otorgado</td>
											<td class="half alignJustify">'.$args['dateAwardPdf'].'</td>
										</tr>
										<tr>
											<td class="half alignJustify">¿La empresa ha sido auditada o sujeta a un proceso de inspección por la autoridad supervisora? En caso afirmativo, proveer detalles.</td>
											<td class="half alignJustify">
												'.($args['audited'] == "1" ? $inputSi : $inputNo).'
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="container pageBreak">
								<p>¿La empresa cuenta con manuales o políticas en materia de anticorrupción?</p>
								'.($args['anticorruption'] == "1" ? $inputSi : $inputNo).'

								<p>¿La empresa cuenta con manuales o políticas en materia de protección de datos y seguridad de la información?</p>
								'.($args['dataProtection'] == "1" ? $inputSi : $inputNo).'

								<p>G. Actividades vulnerables</p>
								<p>¿El giro o actividad de la empresa está regulado como actividad vulnerable*?</p>
								'.($args['vulnerable'] == "1" ? $inputSi : $inputNo).'

								<div class="alignRight">
									<p class="alignJustify">*Actividad vulnerable: se entenderá como actividades vulnerables, aquellas contenidas en el artículo 17 de la Ley Federal para la Prevención e Identificación de Operaciones con Recursos de Procedencia Ilícita.</p>
								</div>
								<p>En caso afirmativo, proporcionar la información siguiente:</p>
								<table class="borders">
									<tbody>
										<tr>
											<td class="half">¿Se encuentra registrada la actividad ante el Servicio de Administración Tributaria?</td>
											<td class="half alignJustify">'.$args['servTrib'].'</td>
										</tr>
										<tr>
											<td class="half">¿Se encuentra al corriente en el cumplimiento de sus obligaciones en esta materia?</td>
											<td class="half alignJustify">'.$args['obligations'].'</td>
										</tr>
									</tbody>
								</table>

								<p>H. Documentación que se deberá enviar</p>
								<table class="borders">
									<tbody>
										<tr>
											<td  class="80 alignJustify">Acta constitutiva con datos de registro.<br>En caso de que no esté inscrita en el registro público por ser de reciente constitución, proporcionar un escrito del representante legal o apoderado, en el que conste la obligación de llevar a cabo la inscripción respectiva y proporcionar los datos correspondientes a Cuenca.</td>
											<td class="20 alignJustify">Enviado</td>
										</tr>
										<tr>
											<td class="80 alignJustify">Constancia de situación fiscal o su equivalente</td>
											<td class="20 alignJustify">Enviado</td>
										</tr>
										<tr>
											<td class="80 alignJustify">Comprobante de domicilio de un periodo no mayor a 3 meses.</td>
											<td class="20 alignJustify">Enviado</td>
										</tr>
										<tr>
											<td class="80 alignJustify">Identificación oficial vigente del representante legal.</td>
											<td class="20 alignJustify">Enviado</td>
										</tr>
										<tr>
											<td class="80 alignJustify">Instrumento en el que consten las facultades del representante legal.</td>
											<td class="20 alignJustify">Enviado</td>
										</tr>
									</tbody>
								</table>
							</div>
	                        	
                        </body>
                    </html>';
        $mpdf->WriteHTML($bodyHtml);
        $ruta = __DIR__ . '/../../assets/proveedores/RegistroProveedor_'.$args['companieName'].'.pdf';
        $mpdf->Output($ruta, 'F');
        return $ruta;
	}

	public function ad_accionista($accionista){

		$idCompanie = $this->session->userdata('datosEmpresa')['id'];

		$query = "INSERT INTO accionistas (IdCompanie, TipoPersona, Accionista, CapitalSocial) 
									VALUES ('".$idCompanie."', '".$accionista["tipoaccionista"]."', 
											'".$accionista["nombreaccionista"]."', '".$accionista["capitalsocial"]."')";

		$this->db->query($query);

		//leemos datos de accionistas
		$queryacc = "SELECT * FROM accionistas WHERE IdCompanie='".$idCompanie."' AND TipoPersona='".$accionista["tipoaccionista"]."' ORDER BY Id ASC";

		if($ResAcc=$this->db->query($queryacc)){
			if ($ResAcc->num_rows() > 0){
                $RResAcc = $ResAcc->result_array();
            }
            else {
                $RResAcc = '';
            }
		}

		return $RResAcc;

	}

	public function add_persona_control($persona){

		$idCompanie = $this->session->userdata('datosEmpresa')['id'];

		$query = "INSERT INTO personacontrol (IdCompanie, PersonaControl, CargoFuncion, Nombre, ApPaterno, ApMaterno, FechaNacimiento, PaisNacimiento, 
												EntidadNacimiento, Rfc, Genero, PaisResidencia, PaisResidenciaFiscal, Nacionalidad, Curp, TipoDireccion, Calle, 
												NumExt, NumInt, Pais, CP, Colonia, Entidad, NumTelefono, TipoIden, NumIden) 
										VALUES('".$idCompanie."', '".$persona["personacontrol"]."', '".$persona["cargofuncion"]."', '".$persona["nombre"]."', 
												'".$persona["appaterno"]."', '".$persona["apmaterno"]."', '".$persona["fechanacimiento"]."', '".$persona["paisnacimiento"]."',
												'".$persona["entidadnacimiento"]."', '".$persona["rfc"]."', '".$persona["genero"]."', '".$persona["paisrecidencia"]."', '".$persona["paisresidenciafiscal"]."', 
												'".$persona["nacionalidad"]."', '".$persona["curp"]."', '".$persona["tipodireccion"]."', '".$persona["calle"]."', 
												'".$persona["numext"]."', '".$persona["numint"]."', '".$persona["pais"]."', '".$persona["cp"]."', '".$persona["colonia"]."', 
												'".$persona["entidad"]."', '".$persona["numtelefono"]."', '".$persona["tipoiden"]."', '".$persona["numiden"]."')";

		if($this->db->query($query)){
			$id = $this->db->insert_id();
			return ['id'=>$id];
		}
		else{
			return FALSE;
		}

	}

	public function genera_pdf_persona_control($persona){

		$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
		$mpdf->SetHTMLHeader('');

		$idCompanie = $this->session->userdata('datosEmpresa')['id'];
		$nameCompanie = $this->session->userdata('datosEmpresa')["legal_name"];

		$query1 = "SELECT * FROM accionistas WHERE idCompanie='".$idCompanie."' AND TipoPersona='M' ORDER BY Id ASC";
		$query2 = "SELECT * FROM accionistas WHERE idCompanie='".$idCompanie."' AND TipoPersona='F' ORDER BY Id ASC";
		$query3 = "SELECT * FROM personacontrol WHERE idCompanie='".$idCompanie."' LIMIT 1";
		$query4 = "SELECT person_name FROM rec_supplier WHERE id_com='".$idCompanie."' LIMIT 1";

		switch (date("m")){
			case '01': $mes='enero'; break;
			case '02': $mes='febrero'; break;
			case '03': $mes='marzo'; break;
			case '04': $mes='abril'; break;
			case '05': $mes='mayo'; break;
			case '06': $mes='junio'; break;
			case '07': $mes='julio'; break;
			case '08': $mes='agosto'; break;
			case '09': $mes='septiembre'; break;
			case '10': $mes='octubre'; break;
			case '11': $mes='noviembre'; break;
			case '12': $mes='diciembre'; break;
		}

		$cadena='<html lang="es-MX">
				<head>
					<style>
					*{
						margin: 0;
						padding: 0;
						box-sizing: border-box;
						font-family: Arial;
						font-size: 12px;
					}
					h3{
						display: block;
						text-align: center;
						font-size: 14px;
						margin: 0px;
						padding: 0px;
					}
					p{
						display: block;
						text-align: justify;
						font-family: Arial;
						margin: 20px;
						padding: 20px;
					}
					.tabla{
						margin: auto;
						border-spacing: 0 !important;
						border-collapse: collapse !important;
					}
					th{
						padding: 10px 20px;
						text-align: center;
						background: #ccc;
						border: 1px solid #000;
						font-family: Arial;
					}
					td{
						padding: 10px 20px;
						text-align: center;
						background: #fff;
						border: 1px solid #000;
						font-family: Arial;
					}
					.pageBreak{
						page-break-before: always;
					}
					</style>
				</head>
				<body>
				
					<h3>'.$nameCompanie.'</h3>
					<p style="text-align: right;">'.date('d').'-'.$mes.'-'.date('Y').'</p>
					<p>Cuenca Tecnología Financiera, S.A. de C.V.,<br />Institución de Fondos de Pago Electrónico<br /><strong>P r e s e n t e</strong></p>
					<p style="text-indent: 50px;">Por este medio, el (los) que suscribe(n) nombre(s) y apellido(s) del administrador(es) y/o representante(s) legal(es) en nombre de mi (nuestra) representada AZUL S.A. DE C.V., manifiesto (manifestamos), que la  conformación de la estructura accionaria de mi (nuestra) representada se satisface de la siguiente forma:</p>
					<table class="tabla">
						<thead>
							<tr>
								<th>ACCIONISTAS DE LA SOCIEDAD</th>
								<th>CAPITAL SOCIAL</th>
							</tr>
						</thead>
						<tbody>';
		if ($ResAccF = $this->db->query($query1)) {
			if ($ResAccF->num_rows() > 0){
				$RResAccF = $ResAccF->result_array();

				foreach($RResAccF AS $value)
				{
					$cadena.='<tr>
								<td>'.$value["Accionista"].'</td>
								<td>$ '.number_format($value["CapitalSocial"], 2).'</td>
							</tr>';
				}
			}
			else {
				$$cadena.= '';
			}
		}
		$cadena.='	</tbody>
					</table>
					<p>Así mismo, hago de su conocimiento, que la estructura accionaria de AZUL INC se compone de las siguientes personas físicas:</p>
					<table class="tabla">
						<thead>
							<tr>
								<th>Accionistas</th>
								<th>CAPITAL SOCIAL</th>
							</tr>
						</thead>
						<tbody>';
		if ($ResAccM = $this->db->query($query2)) {
			if ($ResAccM->num_rows() > 0){
				$RResAccM = $ResAccM->result_array();

				foreach($RResAccM AS $value)
				{
					$cadena.='<tr>
								<td>'.$value["Accionista"].'</td>
								<td>$ '.number_format($value["CapitalSocial"], 2).'</td>
							</tr>';
				}
			}
			else {
				$$cadena.= '';
			}
		}
		$cadena.='	</tbody>
					</table>
					<p>De lo anterior se desprende que ninguna de las personas físicas accionistas de AZUL INC posee más del 25% de acciones por lo que en este acto hago de su conocimiento que la persona que ejerce el control de la sociedad en México es:</p>
					<table class="tabla">
						<thead>
							<tr>
								<th>PERSONA QUE EJERCE EL CONTROL DE LA SOCIEDAD AZUL MÉXICO S.A. DE C.V.</th>
								<th>CARGO O FUNCIÓN</th>
							</tr>
						</thead>
						<tbody>';
		if ($ResPer = $this->db->query($query3)) {
			if ($ResPer->num_rows() > 0){
				$RResPer = $ResPer->result_array();

				foreach($RResPer AS $value)
				{
					$cadena.='<tr>
								<td>'.$value["PersonaControl"].'</td>
								<td>'.$value["CargoFuncion"].'</td>
							</tr>';
				}
			}
			else {
				$$cadena.= '';
			}
		}
		$cadena.='	</tbody>
					</table>
					<p style="color: #c20005;">NOTA.- Además, recabar la información solicitada en el anexo 2, referente a datos personales y domicilio del propietario real o persona que ejerce el control de la sociedad.</p>
					<p>De antemano gracias por las atenciones al presente, quedo de usted por cualquier duda o aclaración.</p>
					<p>Atentamente</p>';
		if ($RepL = $this->db->query($query4)) {
			if ($RepL->num_rows() > 0){
				$RRepL = $RepL->result_array();

				foreach($RRepL AS $value)
				{
					$cadena.='<table><tr><td style="border-top: 1px solid #000; border-bottom: 0px; border-right: 0px; border-left: 0px;">'.$value["person_name"].'</td></tr></table>';
				}
			}
			else {
				$$cadena.= '';
			}
		}
		$cadena.='<div class="pageBreak"></div>
					<h3>ANEXO 2</h3>
					<table class="tabla">
						<tbody>';
		if ($ResPer = $this->db->query($query3)) {
			if ($ResPer->num_rows() > 0){
				$RResPer = $ResPer->result_array();

				foreach($RResPer AS $value)
				{
					$cadena.='<tr>
								<td>Nombre (s)</td>
								<td>'.$value["Nombre"].'</td>
							</tr>
							<tr>
								<td>Ap. Paterno</td>
								<td>'.$value["ApPaterno"].'</td>
							</tr>
							<tr>
								<td>Ap. Materno</td>
								<td>'.$value["ApMaterno"].'</td>
							</tr>
							<tr>
								<td>Fecha de Nacimiento</td>
								<td>'.$value["FechaNacimiento"].'</td>
							</tr>
							<tr>
								<td>País de Nacimiento</td>
								<td>'.$value["PaisNacimiento"].'</td>
							</tr>
							<tr>
								<td>Entidad de Nacimiento</td>
								<td>'.$value["EntidadNacimiento"].'</td>
							</tr>
							<tr>
								<td>RFC con homoclave</td>
								<td>'.$value["Rfc"].'</td>
							</tr>
							<tr>
								<td>Género</td>
								<td>'.$value["Genero"].'</td>
							</tr>
							<tr>
								<td>País de Residencia<br />Nacional/Extranjera</td>
								<td>'.$value["PaisResidencia"].'</td>
							</tr>
							<tr>
								<td>País de Residencia Fiscal</td>
								<td>'.$value["PaisResidenciaFiscal"].'</td>
							</tr>
							<tr>
								<td>Nacionalidad</td>
								<td>'.$value["Nacionalidad"].'</td>
							</tr>
							<tr>
								<td>CURP</td>
								<td>'.$value["Curp"].'</td>
							</tr>}
							<tr>
								<td colspan="2">Domicilio para recibir notificaciones</td>
							</tr>
							<tr>
								<td>Tipo de Dirección</td>
								<td>'.$value["TipoDireccion"].'</td>
							</tr>
							<tr>
								<td>Calle</td>
								<td>'.$value["Calle"].'</td>
							</tr>
							<tr>
								<td>Núm. Ext.</td>
								<td>'.$value["NumExt"].'</td>
							</tr>
							<tr>
								<td>Núm. Int.</td>
								<td>'.$value["NumInt"].'</td>
							</tr>
							<tr>
								<td>País</td>
								<td>'.$value["Pais"].'</td>
							</tr>
							<tr>
								<td>C.P.</td>
								<td>'.$value["CP"].'</td>
							</tr>
							<tr>
								<td>Colonia</td>
								<td>'.$value["Colonia"].'</td>
							</tr>
							<tr>
								<td>Entidad</td>
								<td>'.$value["Entidad"].'</td>
							</tr>
							<tr>
								<td>No. Telefónico</td>
								<td>'.$value["NumTelefono"].'</td>
							</tr>
							<tr>
								<td>Tipo de identificación oficial<br />(INE, pasaporte, …)</td>
								<td>'.$value["TipoIden"].'</td>
							</tr>
							<tr>
								<td>Número de identificación<br/>oficial</td>
								<td>'.$value["NumIden"].'</td>
							</tr>';
				}
			}
			else {
				$$cadena.= '';
			}
		}
		$cadena.='	</tbody>
					</table>
				</body>
				</html>';

		//echo $cadena;

		$mpdf->WriteHTML($cadena);
        $ruta = __DIR__ . '/../../assets/proveedores/RegistroProveedorPersonaControl_'.$idCompanie.'.pdf';
        $mpdf->Output($ruta, 'F');
        return $ruta;

	}

}
