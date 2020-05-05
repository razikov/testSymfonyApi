<?php

namespace App\Controller;

use App\Repository\HeroRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use function array_map;
use function json_decode;

// TODO: авторизация, swagger, лог, кэш
class HeroController
{
    private $heroRepository;

    public function __construct(HeroRepository $heroRepository)
    {
        $this->heroRepository = $heroRepository;
    }
    
    /**
     * @Route("/heroes", name="get_all_heroes", methods={"GET"})
     */
    public function getAll(Request $request)
    {
        // TODO: паджинатор, фильтр, сортировка, валидация данных
        $name = $request->get('name');
        if (is_null($name)) {
            $result = $this->heroRepository->findAll();
        } else {
            $result = $this->heroRepository
                ->createQueryBuilder('h')
                ->where('h.name LIKE :name')
                ->setParameter('name', "%{$name}%")
                ->getQuery()
                ->getResult();
        }
        
        
        $heroes = array_map(function ($item) {
            return $item->toArray();
        }, $result);
        return $this->render($heroes);
    }
    
    /**
     * @Route("/heroes/{id}", name="get_one_hero", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $hero = $this->heroRepository->findOneBy(['id' => $id]);

        return $this->render($hero->toArray());
    }
    
    /**
     * @Route("/heroes", name="create_hero", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'] ?? '';
        $newHero = $this->heroRepository->create($name);

        return $this->render($newHero->toArray());
    }
    
    /**
     * @Route("/heroes/{id}", name="update_hero", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $hero = $this->heroRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $hero->setName($data['name']);

        $updatedHero = $this->heroRepository->update($hero);

        return $this->render($updatedHero->toArray());
    }
    
    /**
     * @Route("/heroes/{id}", name="delete_hero", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $hero = $this->heroRepository->findOneBy(['id' => $id]);

        $this->heroRepository->delete($hero);

        return $this->render([]);
    }
    
    protected function render($data)
    {
        return new JsonResponse($data);
    }
}
