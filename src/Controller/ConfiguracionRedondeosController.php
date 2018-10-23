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

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracionRedondeosController extends Controller
{
    /**
     * @Route("/external/redondeos", name="configuraciones_Redondeo.obtener")
     * @Method({"GET"})
     */
    public function listar(Request $request){

        try {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository(ConfiguracionRedondeos::class)->findAll();
            return new JsonResponse($entities, 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/external/redondeos/update", name="configuraciones_Redondeo.guardar")
     * @Method({"POST"})
     */
    public function update(Request $request)
    {
        $descripcion = $request->request->get('descripcion');
        $ambitosID = $request->request->get('ambito');
        $valor = $request->request->get('valor');


        try {
            $em = $this->getDoctrine()->getManager();
            $ambito = $em->getRepository(AmbitoSTD::class)->findOneBy(array(
                'id'=>$ambitosID,
            ));
            if(!isset($ambito)){
                throw new EntityNotFoundException('No existe ambito con id: '.$ambitosID,404);
            }
            $configRedondeo = $em->getRepository(ConfiguracionRedondeos::class)->findOneBy(array(
                'valor'=>$valor,
                'descripcion'=> $descripcion,
                'ambito'=> $ambitosID
            ));

            if(!isset( $configRedondeo ) ){
                $configRedondeo = new ConfiguracionRedondeos();
            }
            $configRedondeo->setValor($valor);
            $configRedondeo->setDescripcion($descripcion);
            $configRedondeo->setAmbito($ambito);


            $em->persist($configRedondeo);
            $em->flush();
            return new JsonResponse('correcto', 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse($ex->getMessage(), 500);
        }
    }
}