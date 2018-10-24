<?php
/**
 * Created by IntelliJ IDEA.
 * User: egarcia
 * Date: 23/10/18
 * Time: 13:26
 */

namespace App\Controller;


use App\Entity\Gio\ConfiguracionReglas;
use App\Entity\Gio\EmpresaDeipe;
use App\Entity\Gio\UDEIPE\AmbitoSTD;
use App\Entity\Gio\ConfiguracionRedondeos;

use App\Manager\EmpresaManager;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracionRedondeosController extends Controller
{

    /**
     * @Route("/api/empresa/{id}/redondeos/{idRedondeo}", name="configuraciones_Redondeo.mostrar")
     * @Method({"GET"})
     */
    public function show(Request $request, EmpresaManager $empresaManager, EmpresaDeipe $empresa, $idRedondeo){

        try {

            $em = $empresaManager->getEntityManager($empresa);
            $entity = $em->getRepository(ConfiguracionRedondeos::class)->find($idRedondeo);
            return new JsonResponse($entity, 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], $ex->getCode());
        }
    }



    /**
     * @Route("/api/empresa/{id}/redondeos", name="configuraciones_Redondeo.obtener")
     * @Method({"GET"})
     */
    public function listar(Request $request, EmpresaManager $empresaManager, EmpresaDeipe $empresa){

        try {

            $em = $empresaManager->getEntityManager($empresa);
            $entities = $em->getRepository(ConfiguracionRedondeos::class)->findAll();
            return new JsonResponse($entities, 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], $ex->getCode());
        }
    }

    /**
     * @Route("/api/empresa/{id}/redondeos/delete/{idRedondeo}", name="configuraciones_Redondeo.borrar")
     * @Method({"GET"})
     */
    public function delete(Request $request, EmpresaManager $empresaManager, EmpresaDeipe $empresa,$idRedondeo){

        try {

            $em = $empresaManager->getEntityManager($empresa);
            $redondeo = $em->getRepository(ConfiguracionRedondeos::class)->find($idRedondeo);
            if(!isset($redondeo)){
                throw new \Exception('No existe redondeo con esa id',400);
            }
            $reglas = $em->getRepository(ConfiguracionReglas::class)->findBy(array('redondeo'=>$redondeo));
            if(empty($reglas)){
                throw new \Exception('Existe/n una/s regla/s utilizando este redondeo ',400);
            }
            $em->remove($redondeo);
            $em->flush();
            return new JsonResponse('correcto', 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], $ex->getCode());
        }
    }
    /**
     * @Route("/api/empresa/{id}/redondeos/new", name="configuraciones_Redondeo.guardar")
     * @Method({"POST"})
     */
    public function newRedondeo(Request $request, EmpresaManager $empresaManager, EmpresaDeipe $empresa)
    {
        $descripcion = $request->request->get('descripcion');
        $ambitoID = $request->request->get('ambito');
        $valor = $request->request->get('valor');


        try {
            $emDefault = $this->getDoctrine()->getManager();
            $ambito = $emDefault->getRepository(AmbitoSTD::class)->find($ambitoID);
            if(!isset($ambito)){
                throw new EntityNotFoundException('No existe ambito con id: '.$ambitoID,404);
            }
            $em = $empresaManager->getEntityManager($empresa);
            $configRedondeo = $em->getRepository(ConfiguracionRedondeos::class)->findOneBy(array(
                'valor'=>$valor,
                'descripcion'=> $descripcion,
                'ambito'=> $ambitoID
            ));

            if(!isset( $configRedondeo ) ){
                $configRedondeo = new ConfiguracionRedondeos();
            }else{
                throw new \Exception('Redondeo Duplicado{'.$configRedondeo->getId().'}: '.$configRedondeo->getDescripcion(),400);
            }
            $configRedondeo->setId($this->getMaxId($em));
            $configRedondeo->setValor($valor);
            $configRedondeo->setDescripcion($descripcion);
            $configRedondeo->setAmbito($ambitoID);
            $em->persist($configRedondeo);
            $em->flush();

            return new JsonResponse('correcto', 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse($ex->getMessage(), $ex->getCode());
        }
    }

    private function getMaxId($em){
        return $em->createQueryBuilder()
            ->select('MAX(e.id)')
            ->from(ConfiguracionRedondeos::class, 'e')
            ->getQuery()
            ->getSingleScalarResult();
    }

}