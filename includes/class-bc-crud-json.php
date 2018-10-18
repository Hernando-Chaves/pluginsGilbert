<?php 
/**
 * Se activa en la activación del plugin
 *
 * @link       http://misitioweb.com
 * @since      1.0.0
 *
 * @package    Beziercode-Blank
 * @subpackage Beziercode-Blank/includes
 */

/**
 * Crea la estructura CRUD en forMato JSON
 *
 * @since      1.0.0
 * @package    Beziercode-Blank
 * @subpackage Beziercode-Blank/includes
 * @author     Gilbert Rodríguez <email@example.com>
 */

class BC_CRUD_JSON
{

	public function addItem($data, $nombres, $apellidos, $correo, $media)
	{
		// SI ESTÁ VACIO AGREGAMOS LA ESTRUCTURA
		if( $data == '')
		{

			$data = [
				"tabla"=> [
					"nombre"  => "",
				],
				"items" => [
					[
						"id"        => 1,
						"nombres"   => $nombres,
						"apellidos" => $apellidos,
						"correo"    => $correo,
						"media"     => $media,
					]
				]
			];

		} else {//SINO, ITERA LA ESTRUCTURA Y AGREGA EL ITEM

			$items_decode   = json_decode( $data, true );//el parametro true , le indica que devuelva el valor en formato array y no en objeto
			$last_item      = end($items_decode['items']);//OBTENEMOS EL ULTIMO USUARIO
			$last_item_id   = $last_item['id'];//OBTENEMOS EL ID DEL ÚLTIMO USUARIO
			$insert_item_id = ++$last_item_id;

			$items_decode['items'][] = [
				"id"        => $insert_item_id,
				"nombres"   => $nombres,
				"apellidos" => $apellidos,
				"correo"    => $correo,
				"media"     => $media
			];
			                                      
			$data = $items_decode;
		}

		return $data;

	}

	public function readItems($data)
	{
		if( $data != '')
		{
			$data   = json_decode( $data, true );
			$output = '';

			foreach($data['items'] as $v)
			{ 
				$id        = $v['id'];
				$nombres   = $v['nombres'];
				$apellidos = $v['apellidos'];
				$correo    = $v['correo'];
				$media     = $v['media'];

				$output .= "
					<tr data-user=' $id '>
						<td>
							<img class='bc-media' src='$media' alt='$nombres $apellidos'>
						</td>
						<td> $nombres </td>
						<td> $apellidos </td>
						<td> $correo </td>
						<td>
							<button data-edit='$id' class='btn-floating waves-ligh btn'>
								<i class='material-icons'>edit</i>
							</button>
							<button data-remove='$id ' class='btn-floating waves-ligh btn red'>
								<i class='material-icons'>delete</i>
							</button>
						</td>
					</tr>
				"; 
			}
		}

		return $output;
	}

	public function updateItem($arUser, $idUser, $nombres, $apellidos, $correo, $media)
	{
		$arUser = json_decode( $arUser, true );

		foreach($arUser['items'] as $k => $v)
		{
			$id = $v['id'];

			if($idUser == $id)
			{
				$arUser['items'][$k]['nombres']   = $nombres;
				$arUser['items'][$k]['apellidos'] = $apellidos;
				$arUser['items'][$k]['correo']    = $correo;
				$arUser['items'][$k]['media']     = $media;

				break;
			}
		}

		return $arUser;

	}

	public function deleteItem($arUser, $idUser)
	{
		$arUser = json_decode( $arUser, true );

		foreach($arUser['items'] as $k => $v)
		{
			$id = $v['id'];

			if($idUser == $id)
			{
				unset($arUser['items'][$k]);

				break;
			}
		}

		return $arUser;
	}

}