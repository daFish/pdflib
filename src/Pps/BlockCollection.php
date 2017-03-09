<?php

namespace Pdf\Pps;

use ArrayAccess;
use ArrayIterator;
use LogicException;
use IteratorAggregate;
use InvalidArgumentException;

class BlockCollection implements IteratorAggregate, ArrayAccess
{
    /**
     * The block instances.
     *
     * @var Block[]
     */
    protected $blocks = [];

    /**
     * Create a new block collection instance.
     *
     * @param Block[] $blocks
     */
    public function __construct(array $blocks)
    {
        foreach ($blocks as $block) {
            if (!$block instanceof Block) {
                throw new InvalidArgumentException('The first argument must be an array of Block instances');
            }

            $this->blocks[$block->name] = $block;
        }
    }

    /**
     * Automatically fill the blocks with the specified source.
     *
     * @param array|\ArrayAccess $source
     */
    public function fill($source)
    {
        foreach ($this->blocks as $key => $block) {
            if (isset($source[$key])) {
                $block->fill($source[$key]);
            }
        }
    }

    /**
     * Get an iterator for the blocks.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->blocks);
    }

    /**
     * Determine if the block collection is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->blocks) == 0;
    }

    /**
     * Determine if the specified block exists.
     *
     * @param string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->blocks);
    }

    /**
     * Get the specified block.
     *
     * @param string $key
     * @return Block
     */
    public function offsetGet($key)
    {
        return $this->blocks[$key];
    }

    /**
     * Required by the ArrayAccess interface.
     *
     * @param string $key
     * @param mixed $value
     * @throws LogicException when called.
     */
    public function offsetSet($key, $value)
    {
        throw new LogicException('BlockCollection is immutable');
    }

    /**
     * Required by the ArrayAccess interface.
     *
     * @param string $key
     * @throws LogicException when called.
     */
    public function offsetUnset($key)
    {
        throw new LogicException('BlockCollection is immutable');
    }

    /**
     * Filter blocks by the specified type.
     *
     * @param string $type
     * @return BlockCollection
     */
    public function ofType($type)
    {
        $blocks = array_filter($this->blocks, function ($block) use ($type) {
            return is_a($block, $type);
        });

        return $this->newCollection($blocks);
    }

    /**
     * Convert the instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->blocks;
    }

    /**
     * Create a new collection instance.
     *
     * @param array $blocks
     * @return static
     */
    protected function newCollection(array $blocks)
    {
        return new static($blocks);
    }
}
