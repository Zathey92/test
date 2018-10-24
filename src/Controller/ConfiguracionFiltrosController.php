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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracionFiltrosController extends Controller
{
    /**
     * @Route("/api/empresa/{id}/filtros/listar", name="configuraciones_Reglas.obtener")
     * @Method({"GET"})
     */
    public function listar(EmpresaDeipe $empresa, Request $request, EmpresaManager $empresaManager){
        try {

            $em = $empresaManager->getEntityManager($empresa);
            $entities = $em->getRepository(ConfiguracionFiltros::class)->findAll();

            return new JsonResponse($entities, 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse([
                "excepcion" => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/api/empresa/{id}/filtros/new", name="configuraciones_Reglas.guardar")
     * @Method({"POST"})
     */
    public function update(EmpresaDeipe $empresa, Request $request,EmpresaManager $empresaManager)
    {
        $filtroId = $request->request->get('regla_id');
        $precioDesde = $request->request->get('precio_desde');
        $precioHasta = $request->request->get('precio_hasta');
        $precioFiltro = $request->request->get('precio_filtro');
        $valor = $request->request->get('valor');
        $reglaId = $request->request->get('regla_id');
        $proveedorId = $request->request->get('proveedor_id');
        $marcaId = $request->request->get('marca_id');
        $familiaId = $request->request->get('familia_id');
        $activo = $request->request->get('activo');

        try {
            $em = $empresaManager->getEntityManager($empresa);
            $configFiltro = $em->getRepository(ConfiguracionFiltros::class)->findOneBy(array(
                'id'=>$filtroId,
            ));

            if(!isset( $configRegla ) ){
                $configFiltro = new ConfiguracionFiltros();
            }
            $configFiltro->setValor($valor);
            $configFiltro->setActivo($activo);
            $configFiltro->setPrecioDesde($precioDesde);
            $configFiltro->setPrecioHasta($precioHasta);
            $configFiltro->setPrecioFiltro($precioFiltro);
            $configFiltro->setFamilia($familiaId);
            $configFiltro->setMarca($marcaId);
            $configFiltro->setProveedor($proveedorId);
            $configFiltro->setRegla($reglaId);
            $configFiltro->setDatCreacion(new \DateTime());


            $em->persist($configFiltro);
            $em->flush();
            return new JsonResponse($response, 200);

        }
        catch(\Exception $ex) {
            return new JsonResponse($ex->getMessage(), 500);
        }
    }
}