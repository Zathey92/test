<?php
/**
 * Created by IntelliJ IDEA.
 * User: egarcia
 * Date: 23/10/18
 * Time: 13:26
 */

namespace App\Controller\Gio;


use App\Entity\Gio\ConfiguracionFiltros;
use App\Entity\Gio\ConfiguracionRedondeos;
use App\Entity\Gio\ConfiguracionReglas;
use App\Entity\Gio\EmpresaDeipe;
use App\Manager\EmpresaManager;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracionReglasController extends Controller
{
    /**
     * @Route("/api/empresa/{id}/show/{reglaID}", name="configuraciones_Reglas.mostrar")
     * @Method({"GET"})
     */
    public function show(EmpresaDeipe $empresa, Request $request, EmpresaManager $empresaManager,$reglaID){
        try {

            $em = $empresaManager->getEntityManager($empresa);
            $entity = $em->getRepository(ConfiguracionReglas::class)->find($reglaID);
            return new JsonResponse($entity, 200);
        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], $ex->getCode());
        }
    }
    /**
     * @Route("/api/empresa/{id}/reglas", name="configuraciones_Reglas.obtener")
     * @Method({"GET"})
     */
    public function listar(EmpresaDeipe $empresa, Request $request, EmpresaManager $empresaManager){
        try {

            $em = $empresaManager->getEntityManager($empresa);
            $entities = $em->getRepository(ConfiguracionReglas::class)->findAll();
            return new JsonResponse($entities, 200);
        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], $ex->getCode());
        }
    }
    /**
     * @Route("/api/empresa/{id}/delete/{reglaID}", name="configuraciones_Reglas.borrar")
     * @Method({"GET"})
     */
    public function delete(EmpresaDeipe $empresa, Request $request, EmpresaManager $empresaManager,$reglaID){
        try {

            $em = $empresaManager->getEntityManager($empresa);
            $regla = $em->getRepository(ConfiguracionReglas::class)->find($reglaID);
            if(!isset($regla)){
                throw new \Exception('No existe regla con esa id',400);
            }
            $filtro = $em->getRepository(ConfiguracionFiltros::class)->findBy(array('regla'=>$regla));
            if(empty($filtro)){
                throw new \Exception('Existe/n uno/s filtro/s utilizando esta regla ',400);
            }
            $em->remove($regla);
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
     * @Route("/api/empresa/{id}/reglas/new", name="configuraciones_Reglas.guardar")
     * @Method({"POST"})
     */
    public function newRegla(EmpresaDeipe $empresa, Request $request,EmpresaManager $empresaManager)
    {
        $reglaId = $request->request->get('regla');
        $aplicarDesde = $request->request->get('aplicar_desde');
        $operacion = $request->request->get('operacion');
        $valor = $request->request->get('valor');
        $redondeoId = $request->request->get('redondeo');
        $descripcion = $request->request->get('descripcion');
        $eliminada = $request->request->get('eliminada');

        try {
            $em = $empresaManager->getEntityManager($empresa);
            $redondeo = $em->getRepository(ConfiguracionRedondeos::class)->find($redondeoId);
            if(!isset($redondeo)){
                throw new Exception('No existe redondeo con id: '.$redondeoId,404);
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
            }
            $configReglas->setId($this->getMaxId($em));
            $configReglas->setValor($valor);
            $configReglas->setDescripcion($descripcion);
            $configReglas->setAplicarDesde($aplicarDesde);
            $configReglas->setOperacion($operacion);
            $configReglas->setRedondeo($redondeo);
            $configReglas->setEliminada($eliminada);
            $configReglas->setDatCreacion(new \DateTime());

            $em->persist($configReglas);
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
            ->from(ConfiguracionReglas::class, 'e')
            ->getQuery()
            ->getSingleScalarResult();
    }
}