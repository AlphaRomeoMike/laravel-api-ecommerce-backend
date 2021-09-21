<?php

	namespace App\Exceptions\Api;

	use Exception;
	use Illuminate\Http\JsonResponse;
	use Request;

	class CategoryNotFoundException extends Exception
	{
		/**
		 * Register the exception handling callbacks for the application.
		 *
		 * @return void
		 */
		public function register()
		{
			//
		}

		/**
		 * Register the exception handling callbacks for the application.
		 *
		 * @param Request $request
		 * @return JsonResponse
		 */
		public function render($request)
		{
			return response()->json([
				'message'   => 'Category not found on ' . $request->id
			]);
		}
	}
