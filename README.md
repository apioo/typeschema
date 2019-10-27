# TypeSchema

## About

TypeSchema is a JSON format to describe JSON structures. It helps to build
schemas which can be used for code generation and other use cases where a
processor needs to understand the schema without the actual data. It is based
on JSON Schema and every TypeSchema is automatically a valid JSON Schema.

## Why

Many people are already familiar with JSON Schema. The intent of JsonSchema is
to validate JSON documents. This works great but it has problems to describe
JSON documents since you always need to validate a schema alongside the actual
data.

This mindset of JsonSchema is a common misunderstanding and there are many
people who try to use JsonSchema for code generation but there are many pitfalls
due to the nature of the JsonSchema specification. These pitfalls are explained
in our [migration document](migration.md). 

Basically TypeSchema is a more stricter subset of JsonSchema which allows you to
write clean schemas which can be easily turned into code. So every TypeSchema
which you write is automatically also a valid JsonSchema bot not vice versa.

## Specification

The specification is directly generated from our TypeSchema meta schema:

* [HTML](https://chriskapp.github.io/typeschema/schema/schema.htm)
* [TypeScript](https://chriskapp.github.io/typeschema/schema/schema.ts)
* [TypeSchema](https://chriskapp.github.io/typeschema/schema/schema.json)

You can use any valid JSON Schema validator with our TypeSchema meta schema to
validate whether your schema is valid.

### Overview

In a TypeSchema you must define a [Root](https://chriskapp.github.io/typeschema/schema/schema.htm#TypeSchema)
schema which must be of type `object`. This object must contain specific
[Properties](https://chriskapp.github.io/typeschema/schema/schema.htm#Properties).
The [Definitions](https://chriskapp.github.io/typeschema/schema/schema.htm#Definitions)
keyword contains a list of schemas which can be reused.

In TypeSchema every schema can be assigned to exactly one specific type based on
the used keywords. Through this logic a processor can understand the schema
independent of the actual data. The following list shows all available types:

#### Object-Type
* [Struct](https://chriskapp.github.io/typeschema/schema/schema.htm#StructProperties)
* [Map](https://chriskapp.github.io/typeschema/schema/schema.htm#MapProperties)

#### Array-Type
* [Array](https://chriskapp.github.io/typeschema/schema/schema.htm#ArrayProperties)

#### Scalar-Type
* [Boolean](https://chriskapp.github.io/typeschema/schema/schema.htm#BooleanProperties)
* [Number](https://chriskapp.github.io/typeschema/schema/schema.htm#NumberProperties)
* [String](https://chriskapp.github.io/typeschema/schema/schema.htm#StringProperties)

#### Intersection-Type
* [AllOf](https://chriskapp.github.io/typeschema/schema/schema.htm#AllOfProperties)

#### Union-Type
* [OneOf](https://chriskapp.github.io/typeschema/schema/schema.htm#OneOfProperties)

#### Reference-Type
* [Reference](https://chriskapp.github.io/typeschema/schema/schema.htm#ReferenceType)
