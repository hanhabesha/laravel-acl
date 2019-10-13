<?php

namespace Junges\ACL\Solutions\Providers;

use Throwable;
use Facade\IgnitionContracts\BaseSolution;
use ReflectionClass;
use Facade\IgnitionContracts\HasSolutionsForThrowable;
use Junges\ACL\Exceptions\GroupDoesNotExistException;
use Junges\ACL\Solutions\GroupDoesNotExistSolution;

class GroupDoesNotExistSolutionProvider implements HasSolutionsForThrowable
{
    /**
     * The slug to create for the group.
     * 
     * @var string $slug
     */
    private $slug;

    /**
     * Can the exception be solved
     * 
     * @param \Throwable $throwable
     * @return bool
     */
    public function canSolve(Throwable $throwable): bool
    {
        if(! $throwable instanceof GroupDoesNotExistException) {
            return false;
        }
        $pattern = '/'.trans('acl::acl.group_does_not_exist_with_slug').' ([^\s]+)/m';
    
        if (! preg_match($pattern, $throwable->getMessage(), $matches)) {
            return false;
        }
        
        $this->slug = $matches[1];

        return true;
    }

    /**
     * The solutions for the missing traits
     * 
     * @param \Throwable $throwable
     * @return array
     */
    public function getSolutions(Throwable $throwable): array
    {
        return [
            new GroupDoesNotExistSolution($this->slug),
        ];
    }
}
