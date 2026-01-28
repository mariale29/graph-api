<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Requests\NodeRequest;
use App\Http\Resources\NodeResource;
use NumberFormatter;

class NodeController extends Controller
{
   /**
 * @OA\Post(
 * path="/api/nodes",
 * summary="Crear un nodo con headers específicos",
 * tags={"Nodos"},
 * @OA\Parameter(
 * name="Accept-Language",
 * in="header",
 * required=false,
 * description="Idioma preferido para la respuesta",
 * @OA\Schema(type="string", default="es")
 * ),
 * @OA\Parameter(
 * name="X-Timezone",
 * in="header",
 * required=false,
 * description="Zona horaria del cliente",
 * @OA\Schema(type="string", default="America/Caracas")
 * ),
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"id", "parent_id"},
 * @OA\Property(property="id", type="integer", example=17),
 * @OA\Property(property="parent_id", type="integer", example=16)
 * )
 * ),
 * @OA\Response(
 * response=201,
 * description="Nodo creado correctamente"
 * ),
 * @OA\Response(
 * response=500,
 * description="Error interno"
 * )
 * )
 */
    public function store(NodeRequest $request)
    {
        try{
        $data = $request->validated();

        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $data['title'] = $formatter->format($data['id']);

        $node = Node::create($data);

        return new NodeResource($node);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error inesperado al crear el nodo.',
                'debug' => $e->getMessage() 
            ], 500);
        }
    }
    /**
 * @OA\Get(
 * path="/api/nodes",
 * summary="Obtener nodos con filtro de padre y profundidad",
 * tags={"Nodos"},
 * @OA\Parameter(
 * name="parent_id",
 * in="query",
 * description="ID del nodo padre para filtrar (opcional)",
 * required=false,
 * @OA\Schema(type="integer")
 * ),
 * @OA\Parameter(
 * name="depth",
 * in="query",
 * description="Nivel de profundidad de hijos a cargar (ej. 1 o 2)",
 * required=false,
 * @OA\Schema(type="integer", default=1)
 * ),
 * @OA\Response(
 * response=200,
 * description="Lista de nodos obtenida. Ejemplos: /api/nodes (raíces), /api/nodes?depth=2 (raíces con 2 niveles)",
 * @OA\JsonContent(type="array", @OA\Items(type="object"))
 * ),
 * @OA\Response(
 * response=400,
 * description="Parámetros de consulta inválidos"
 * )
 * )
 */
    public function index(Request $request)
    {
        
        $parentId = $request->query('parent_id'); 
        $depth = (int) $request->query('depth', 0); 
        
        $query = Node::where('parent_id', $parentId);
        
        if ($depth > 0) {
            $relations = 'children';                
            for ($i = 1; $i < $depth; $i++) {
                $relations .= '.children';
            }
            $query->with($relations);
        }    
            
        return response()->json($query->get(), 200);
    }
    /**
     * @OA\Get(
     * path="/api/parent",
     * summary="Obtener lista de nodos padres",
     * tags={"Nodos"},
     * @OA\Response(
     * response=200,
     * description="Lista de nodos raíces (sin padres) obtenida con éxito",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(type="object")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor al procesar la consulta"
     * )
     * )
     */
    public function getParent(Request $request)
    {
        $query = Node::whereNull('parent_id');        

        return response()->json($query->get(), 200);
    }
    /**
     * @OA\Get(
     * path="/api/children/{node}",
     * summary="Obtener nodos hijos dado su padre",
     * tags={"Nodos"},
     * @OA\Parameter(
     * name="node",
     * in="path",
     * description="ID del nodo padre",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operación exitosa. Devuelve una lista de hijos o un array vacío si no tiene.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(type="object") 
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="El nodo solicitado no existe"
     * )
     * )
     */
    public function getChildren($id) 
    {
        $node = Node::find($id);

        if (!$node) {
            return response()->json([
                'status' => 'error',
                'message' => 'El nodo solicitado no existe.'
            ], 404);
        }

        $children = Node::where('parent_id', $id)->get();

    
        if ($children->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Este nodo no tiene hijos.',
                'data' => [] 
            ], 200);
        }

        return response()->json($children, 200);
    }
   /**
 * @OA\Delete(
 * path="/api/nodes/{node}",
 * summary="Eliminar un nodo",
 * tags={"Nodos"},
 * @OA\Parameter(
 * name="node",
 * in="path",
 * description="ID del nodo a eliminar",
 * required=true,
 * @OA\Schema(type="integer")
 * ),
 * @OA\Response(
 * response=200,
 * description="Nodo eliminado correctamente"
 * ),
 * @OA\Response(
 * response=400,
 * description="No se puede eliminar un nodo que posee hijos (children)."
 * ),
 * @OA\Response(
 * response=404,
 * description="El nodo solicitado no existe"
 * )
 * )
 */

    public function destroy(Node $node)
    {
        
        if ($node->children()->exists()) {
            return response()->json([
                'error' => 'No se puede eliminar un nodo que posee children.'
            ], 400);
        }

        $node->delete();
        return response()->json([
            'message' => 'Nodo eliminado correctamente.'
        ], 200);
    }
}
