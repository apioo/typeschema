# TypeSchema

## About

TypeSchema is a JSON format to describe JSON structures. It helps to build
schemas which can be used for code generation and other use cases where a
processor needs to understand the schema without the actual data. It is
compatible with JSON Schema and every TypeSchema is automatically a valid JSON
Schema but not vice versa.

## Why

You might question: Why not use JSON Schema?

For code generators it is difficult to work with JSON Schema. In JSON Schema you
dont need to provide any keywords i.e. `{}` is a valid JSON Schema which
basically allows every value and the defined keywords are applied based on the
actual data. A code generator on the other hand needs to determine a concrete
type of a schema without the actual data. JSON Schema contains many keywords
which contain logic like `dependencies`, `not`, `if/then/else` which are
basically not needed for code generators and really complicate building them. We
have also explained some pitfalls in our [migration document](migration.md).

Because of the need for a better schema specification which is optimized for
code generation we have developed TypeSchema. Basically TypeSchema is a more
stricter subset of JSON Schema which allows you to write clean schemas which can
be easily turned into code. Every TypeSchema which you write is automatically
also a valid JSON Schema bot not vice versa. Since this specification removes
and restricts only keywords TypeSchema is compatible down to JSON Schema
`draft-04`. You can think of TypeSchema is to JSON Schema what TypeScript is to
Javascript.

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

In TypeSchema you must define a [Root](https://chriskapp.github.io/typeschema/schema/schema.htm#TypeSchema)
schema which must be of type `object`. This object must contain specific
[Properties](https://chriskapp.github.io/typeschema/schema/schema.htm#Properties).
The [Definitions](https://chriskapp.github.io/typeschema/schema/schema.htm#Definitions)
keyword contains a list of schemas which can be reused.

In TypeSchema every schema can be assigned to exactly one specific type based on
the used keywords. The following list shows all available types:

#### Object-Type
##### [Struct](https://chriskapp.github.io/typeschema/schema/schema.htm#StructProperties)

A struct contains a fix set of defined properties.

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

A map contains variable key value entries of a specific type.

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

An array contains an ordered list of a specific type.

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

Represents a boolean value.

```json
{
  "type": "boolean"
}
```

##### [Number](https://chriskapp.github.io/typeschema/schema/schema.htm#NumberProperties)

Represents a number value (contains also integer).

```json
{
  "type": "number",
  "minimum": 12
}
```

##### [String](https://chriskapp.github.io/typeschema/schema/schema.htm#StringProperties)

Represents a string value.

```json
{
  "type": "string",
  "minLength": 12
}
```

#### Intersection-Type
##### [AllOf](https://chriskapp.github.io/typeschema/schema/schema.htm#AllOfProperties)

An intersection type combines multiple schemas into one.

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

An union type can contain one of the provided schemas.

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

Represents a reference to another schema.

```json
{
  "$ref": "#/definitions/Car"
}
```

#### Generic-Type
##### [Generic](https://chriskapp.github.io/typeschema/schema/schema.htm#GenericType)

Represents a generic type.

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
