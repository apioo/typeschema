# TypeSchema

## Tests

This directory contains test TypeSchema specifications using different features of the specification.
If you want to build a generator or parser it is recommended to test your library against these tests.
Your generator is level 5 compliant in case it can work with all levels of the specification.

## Level 1

Tests whether it is possible to work with a simple structures. It tests also that it is possible to
reference a different struct. This is the most basic feature which every processor should support.

## Level 2

Tests whether it is possible to use array and map data types. Inline means that the native array/map
data types are used. Array and map definition types result in a custom array or map implementation.

## Level 3

Tests whether it is possible to extend a struct. If supported a generator should produce two classes
with an actual extend.

## Level 4

Tests whether it is possible to use generics. Generic placeholder at a struct can be replaced on usage
with actual types. A generator should produce actual generics if the language supports this.

## Level 5

Tests whether it is possible to use discriminated union. Through a discriminated union it is possible
to use different schemas depending on a discriminated type value.
