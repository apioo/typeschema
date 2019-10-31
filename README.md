# TypeSchema

## About

TypeSchema is a JSON format to describe JSON structures. It helps to build
schemas which can be used for code generation and other use cases where a
processor needs to understand the schema without the actual data. It is based
on JSON Schema and every TypeSchema is automatically a valid JSON Schema.

## Why

Many people are already familiar with JSON Schema. The intent of JSON Schema is
to validate JSON documents. This works great but it is problematic for code
generation since you always need to use the schema alongside the actual data. We
have explained some pitfalls in our [migration document](migration.md).

Because of the need for a better schema which can be used for code generation
we have developed TypeSchema. Basically TypeSchema is a more stricter subset of
JSON Schema which allows you to write clean schemas which can be easily turned
into code. So every TypeSchema which you write is automatically also a valid
JSON Schema bot not vice versa.

## Specification

The specification is directly generated from our TypeSchema meta schema:

* [HTML](https://chriskapp.github.io/typeschema/schema/schema.htm)
* [TypeScript](https://chriskapp.github.io/typeschema/schema/schema.ts)
* [TypeSchema](https://chriskapp.github.io/typeschema/schema/schema.json)

You can use any valid JSON Schema validator with our TypeSchema meta schema to
validate whether your schema is valid.

The type system of TypeSchema matches perfectly to the type system of
TypeScript and we have also automatically generated a TypeSchema definition
based on our specification.

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
##### [Struct](https://chriskapp.github.io/typeschema/schema/schema.htm#StructProperties)

A struct represents an object with a set of fix properties.

```json
{
  "type": "object",
  "properties": {
    "title": {
      "type": "string"
    },
    "createDate": {
      "type": "string",
      "format": "date-time"
    }
  }
}
```

##### [Map](https://chriskapp.github.io/typeschema/schema/schema.htm#MapProperties)

A map contains a variable count of key/value entries with a specific type.

```json
{
  "type": "object",
  "additionalProperties": {
    "type": "string"
  }
}
```

#### Array-Type
##### [Array](https://chriskapp.github.io/typeschema/schema/schema.htm#ArrayProperties)

An array contains a list of specific types

```json
{
  "type": "array",
  "items": {
    "type": "string"
  }
}
```

#### Scalar-Type
##### [Boolean](https://chriskapp.github.io/typeschema/schema/schema.htm#BooleanProperties)

```json
{
  "type": "boolean"
}
```

##### [Number](https://chriskapp.github.io/typeschema/schema/schema.htm#NumberProperties)

```json
{
  "type": "number",
  "minimum": 12
}
```

##### [String](https://chriskapp.github.io/typeschema/schema/schema.htm#StringProperties)

```json
{
  "type": "string",
  "minLength": 12
}
```

#### Intersection-Type
##### [AllOf](https://chriskapp.github.io/typeschema/schema/schema.htm#AllOfProperties)

```json
{
  "allOf": [{
    "$ref": "#/definitions/Person"
  }, {
    "$ref": "#/definitions/Student"
  }]
}
```

#### Union-Type
##### [OneOf](https://chriskapp.github.io/typeschema/schema/schema.htm#OneOfProperties)

```json
{
  "oneOf": [{
    "$ref": "#/definitions/Car"
  }, {
    "$ref": "#/definitions/Train"
  }]
}
```

#### Reference-Type
##### [Reference](https://chriskapp.github.io/typeschema/schema/schema.htm#ReferenceType)

```json
{
  "$ref": "#/definitions/Car"
}
```

#### Generic-Type
##### [Generic](https://chriskapp.github.io/typeschema/schema/schema.htm#GenericType)

**NOTE: This is a TypeSchema specific feature which is not available in JSON
Schema so use it only if you use a schema processor which supports TypeSchema**

Through the `$generic` keyword it is possible to define a schema placeholder.
I.e. if you want to reuse a collection schema with different entries:

```json
{
  "type": "object",
  "properties": {
    "totalResults": {
      "type": "integer"
    },
    "itemsPerPage": {
      "type": "integer"
    },
    "entries": {
      "$generic": "T"
    }
  }
}
```

Through the `$template` keyword it is possible to insert a concrete schema to
the placeholder.

```json
{
  "$ref": "#/definitions/Map",
  "$template": {
    "T": {
      "$ref": "#/definitions/News"
    }
  }
}
```
