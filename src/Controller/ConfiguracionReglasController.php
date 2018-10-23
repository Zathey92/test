<?php
/**
 * Created by IntelliJ IDEA.
 * User: egarcia
 * Date: 23/10/18
 * Time: 13:26
 */

namespace App\Controller;


use App\Entity\AmbitoSTD;
use App\Entity\ConfiguracionRedondeos;

use App\Entity\ConfiguracionReglas;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracionReglasController extends Controller
{
    /**
     *
     * @Route("/external/reglas", name="configuraciones_Reglas.obtener")
     * @Method({"GET"})
     */
    public function listar(Request $request){

        try {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository(ConfiguracionReglas::class)->findAll();
            return new JsonResponse($entities, 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/external/reglas/update", name="configuraciones_Reglas.guardar")
     * @Method({"POST"})
     */
    public function update(Request $request)
    {
        $descripcion = $request->request->get('descripcion');
        $redondeoId = $request->request->get('redondeo');
        $aplicarDesde = $request->request->get('aplicar_desde');
        $operacion = $request->request->get('operacion');
        $eliminada = $request->request->get('eliminada');
        $valor = $request->request->get('valor');


        try {
            $em = $this->getDoctrine()->getManager();

            $redondeo = $em->getRepository(ConfiguracionRedondeos::class)->findOneBy(array(
                'id'=>$redondeoId,
            ));
            if(!isset($redondeo)){
                throw new EntityNotFoundException('No existe redondeo con id: '.$redondeoId,404);
            }
            $configReglas = $em->getRepository(ConfiguracionReglas::class)->findOneBy(array(
                'valor'=>$valor,
                'descripcion'=> $descripcion,
                'aplicarDesde'=> $aplicarDesde,
                'redondeo'=>$redondeoId,
                'operacion'=>$operacion,
                'eliminada'=>$eliminada,
            ));

            if(!isset( $configReglas ) ){
                $configReglas = new ConfiguracionReglas();
                // Utilizar aqui para que la fecha no cambia cuandose modifique la regla
                // $configReglas->setDatCreacion(new \DateTime());
            }
            $configReglas->setValor($valor);
            $configReglas->setDescripcion($descripcion);
            $configReglas->setAplicarDesde($aplicarDesde);
            $configReglas->setOperacion($operacion);
            $configReglas->setRedondeo($redondeo);
            $configReglas->setEliminada($eliminada);
            //Se actualiza con cada cambio
            $configReglas->setDatCreacion(new \DateTime());

            $em->persist($configReglas);
            $em->flush();
            return new JsonResponse('correcto', 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse($ex->getMessage(), 500);
        }
    }
}