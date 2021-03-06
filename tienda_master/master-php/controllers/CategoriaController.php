<?php
require_once 'models/Categoria.php';
require_once 'models/Producto.php';

class categoriaController
{

	public function index()
	{
		Utils::isAdmin();
		$categoria = new Categoria();
		$categorias = $categoria->getAll();
		$totalCat = $categoria->getAllCat();
		
		for ($x = 1; $x <= $totalCat; $x++) {
			$totalStock[$x] = $categoria->getTotalCategorias($x);
		}

		
		for ($x = 1; $x <= $totalCat; $x++) {
			$totalVendidos[$x] = $categoria->getAllVendidos($x);
		}
		//var_dump($totalVendidos);

		require_once 'views/categoria/index.php';
	}

	public function ver()
	{
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			// Conseguir categoria
			$categoria = new Categoria();
			$categoria->setId($id);
			$categoria = $categoria->getOne();

			// Conseguir productos;
			$producto = new Producto();
			$producto->setCategoria_id($id);
			$productos = $producto->getAllCategory();
		}

		require_once 'views/categoria/ver.php';
	}

	public function crear()
	{
		Utils::isAdmin();
		require_once 'views/categoria/crear.php';
	}

	//A�ADINOS LA FUNCION RENOMBRAR
	public function renombrar()
	{
		Utils::isAdmin();
		if (isset($_POST) && isset($_POST['nuevonombre'])) {
			// Guardar la categoria en bd
			$categoria = new Categoria();
			$categoria->setNombre($_POST['nuevonombre']);
			$categoria->setId($_POST['id']);
			$renombrar = $categoria->renombrar();

			header("Location:" . base_url . "categoria/index");
		}
		require_once 'views/categoria/renombrar.php';
	}


	public function save()
	{
		Utils::isAdmin();
		if (isset($_POST) && isset($_POST['nombre'])) {
			// Guardar la categoria en bd
			$categoria = new Categoria();
			$categoria->setNombre($_POST['nombre']);
			$save = $categoria->save();
		}
		header("Location:" . base_url . "categoria/index");
	}
}
