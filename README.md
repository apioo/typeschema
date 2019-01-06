TypeJsonSchema
==============

# About

TypeJsonSchema is a JSON Schema subset to describe the structure of JSON
documents. It is has well defined keywords which restricts the JSON Schema
keywords to a subset with a deterministic behaviour. This helps to build schemas
which can be used for code generation and other use cases where a processor
needs to understand the schema without the actual data. As side effect we think
also that type schemas are cleaner and easier to evolve over time since they
forbid specific pitfalls which are allowed in a normal JSON Schema.

# Why

Many people are already familiar with JsonSchema. The intent of JsonSchema is to
validate JSON documents. This works great but it has problems to describe JSON
documents since you always need to validate a schema alongside the actual data.

This mindset of JsonSchema is a common misunderstanding and there are many
people who try to use JsonSchema for code generation but in the end they always
fail due to the nature of the JsonSchema specification.

This is where TypeJsonSchema comes in to play, it is a well defined subset of
JSON Schema which helps you to develop clean JSON schemas which can be easily
used to generate code and other formats.

# Meta-Schema

We have developed a clean meta schema which you can use to check whether your
JSON schema is already a TypeJsonSchema. Please take a look at the [schema](schema/schema.json).

# Specification

## <a name="abstract"></a>Abstract

In the JSON Schema core specification all keywords are optional and are applied
in context with the actual data. The idea of this specification is to build
schemas which have a distinct meaning independent of the actual data and which
can be used to generate different representations i.e. model classes of a
programming language. Because of this we must restrict existing keywords and
must make specific keywords mandatory depending on the context.

In this specification every schema is exactly assigned to a specific type of
schema: `Definition`, `Combination` or `Reference`. The distinction is made
based on the used keywords.

### <a name="abstract-definition"></a>Definition

A definition schema is a schema which describes a concrete type. It must follow
the rules:

* Every schema MUST have a `type` keyword. The type must be one of: `object`,
  `array`, `boolean`, `number`, `integer` or `string`
* Every schema of type `object` MUST have a `title` keyword. This is required so
  that code generators can build class names or other identifiers based on this
  title.
* Every schema of type `object` is either a struct (MUST have a `properties`
  keyword) or a map (MUST have a `additionalProperties` keyword).
* Every schema of type `array` MUST have an `items` keyword. The items can only
  contain definition (`object`, `boolean`, `number`, `string`) or reference
  schemas.
* It is not possible to mix multiple constraints i.e. a schema of type `string`
  can only use string specific validation keywords i.e. `minLength`.

### <a name="abstract-combination"></a>Combination

A combination schema combines multiple schemas in a specific way. 
It must follow the rules:

* Every schema MUST have one of the following keywords: `allOf` or `oneOf`.
* The value must be an array which can contain only definition or reference
  schemas. These schemas MUST be of type `object`.

### <a name="abstract-reference"></a>Reference

A reference schema makes a reference to another schema. It must follow the
rules:

* Every schema MUST have the keyword `$ref`.
* A reference schema MUST follow the same rules as a definition schema. That
  means i.e. if a reference is used inside the `allOf` keyword it MUST only
  reference object types.

----

## <a name="schema"></a>Keywords

The following keywords are allowed:

* [Definition](#definition)
  * [Common](#)
  * [Object](#)
    * [Struct](#)
    * [Map](#)
  * [Array](#)
  * [Scalar](#)
    * [Boolean](#)
    * [Number](#)
    * [String](#)
* [Combination](#)
* [Reference](#)

### Definition

#### <a name="common"></a>Common

The following keywords can be used in any definition schema:

Field Name | Type | Description
---|:---:|---
title | `string` | Distinct word which represents this type. Types with the same title should represent the same constraints.
description | `string` | Contains a general description of this property. Should only contain simple text and no line breaks since the description is may be used in code comments or other character sensitive environments.
type | `string` | Must be one of `boolean`, `object`, `array`, `number`, `integer` or `string`

#### <a name="object"></a>Object

##### <a name="struct"></a>Struct

A struct is an object which MUST have at least a `type`, `title"` and `properties`
keyword.

Field Name | Type | Description
---|:---:|---
properties | `map[string]Schema` |
required | `[string]`

```json
{
    "title": "Person",
    "type": "object",
    "properties": {
        "forname": {
            "type": "string"
        },
        "lastname": {
            "type": "string"
        }
    }
}
```

##### <a name="map"></a>Map

A map is an object which MUST have at least a `type`, `title` and `additionalProperties`
keyword.

Field Name | Type | Description
---|:---:|---
additionalProperties | `Schema` |
maxProperties | `integer` |
minProperties | `integer` |

```json
{
    "title": "Config",
    "type": "object",
    "additionalProperties": {
        "type": "string"
    }
}
```
                        
#### <a name="array"></a>Array

If a schema has a `type` keyword which is `array` the following keywords can be
used:

Field Name | Type | Description
---|:---:|---
items | `Schema` |
maxItems | `integer` |
minItems | `integer` |
uniqueItems | `boolean` |

#### <a name="scalar"></a>Scalar

If a schema has a `type` keyword which is either `boolean`, `number`, `integer` or
`string` the following keywords can be used:

Field Name | Type | Description
---|:---:|---
format | `string` | Describes a more detailed format of the provided value. I.e. if the format is "date-time" a code generator could utilize the standard date class of the target programming language.
enum | `[string]` | An array of allowed values

##### <a name="boolean"></a>Boolean

If a schema has a `type` keyword which is `boolean` no keywords are available.

##### <a name="number"></a>Number

If a schema has a `type` keyword which is either `number` or `integer` the
following keywords can be used:

Field Name | Type | Description
---|:---:|---
multipleOf | `integer` |
maximum | `integer` |
exclusiveMaximum | `boolean` |
minimum | `integer` |
exclusiveMinimum | `boolean` |

##### <a name="string"></a>String

If a schema has a `type` keyword which is `string` the following validation
keywords can be used:

Field Name | Type | Description
---|:---:|---
maxLength | `integer` |
minLength | `integer` |
pattern | `string` |

### <a name="combination"></a>Combination

The following keywords can be used to describe a combination schema:

Field Name | Type | Description
---|:---:|---
allOf | `[ObjectOrReference]` |
oneOf | `[ObjectOrReference]` |

```json
{
    "allOf": [{
        "$ref": "#/definitions/person"
    }, {
        "title": "teacher",
        "type": "object",
        "properties": {
            "classroom": {
                "type": "string"
            }
        }
    }]
}
```

### <a name="reference"></a>Reference

The following keywords can be used to describe a reference schema:

Field Name | Type | Description
---|:---:|---
$ref | `string` |

----

## Not supported keywords

The following keywords are not supported. Not supported means they have no
special meaning in this specification and processors should ignore those
keywords.

* The `patternProperties` keyword is not supported.
* The `type` keyword MUST be a string. The array notation is not supported.
* The `null` type is not supported.
* The `not` keyword is not supported.
* The `dependencies` keyword is not supported.
* The `additionalItems` keyword is not supported.

Note: Since the JsonSchema evolves and potentially creates new validation
keywords a TypeJsonSchema processor should in general ignore all not known
keywords.

----

# Restrictions

The following list covers all major restrictions on JsonSchema. This should help
to migrate your JsonSchema to TypeJsonSchema:

## No-Type

### Invalid

```json
{
}
```

In JsonSchema it is possible to define no keyword which means every value is
valid.

### Reasoning

In TypeJsonSchema every schema must have at least a `type` keyword. This is
required so that a parser knows at least which type is expected. Depending on
the type there are maybe also other keywords required.

## Array-Type

### Invalid

```json
{
  "type": ["string", "number"],
  "minLength": 12
}
```

In JsonSchema it is possible to allow multiple types. The validator looks at the
actual data and execute the `minLength` assertion only in case the input is a
string if its a number the check is ignored.

### Reasoning

Based on this schema it is impossible to generate a strongly typed class since
there can be only one type. Therefore In TypeJsonSchema the type must be a
string and it is not possible to define multiple types.

## Null-Type

### Invalid

```json
{
  "type": "null"
}
```

In JsonSchema it is possible to define the `null` type.

### Reasoning

We think that null is not a data type but rather an attribute of a type. Because
of that TypeJsonSchema has the `nullable` keyword which can be `true` or `false`
for every type.

## Mixed-Assertions

### Invalid

```json
{
  "type": "string",
  "minLength": 12,
  "minimum": 12
}
```

In JsonSchema it is possible to define multiple assertions for different types.

### Reasoning

Since in TypeJsonSchema you can define only one type, you can also use only the
assertions which are fitting for the type. I.e. `minimum` for the `number` type
or `minLength` for the `string` type but not both.

## Pattern-Properties

### Invalid

```json
{
  "type": "object",
  "patternProperties": {
    "^S_": {
      "type": "string"
    },
    "^I_": {
      "type": "integer"
    }
  }
}
```

In JsonSchema it is possible to use pattern properties to apply different
schemas based on the key.

### Reasoning

In TypeJsonSchema you need to decide between a struct or map. A struct contains
hardcoded properties through the `properties` keyword and a map makes use of the
`additionalProperties` keyword. For the `additionalProperties` keyword every value
must follow the same schema. Code generators can not usefully understand those
properties and we think also that the `patternProperties` keyword promotes
bad data design. 

## Object-Title

### Invalid

```json
{
  "type": "object",
  "properties": {
    "foo": {
      "type": "string"
    }
  }
}
```

In JsonSchema an object must not have a title.

### Reasoning

In TypeJsonSchema every `object` type must have a `title` keyword. This is
required since processors often need an identifier when generating code or other
formats. This helps processors to avoid generating the same type multiple times
and allows the usage of a fitting name. Relying on the "key" of the property is
not possible since different keys point to the same schema.

## Of-Types

### Invalid

```json
{
  "allOf": [{
    "type": "string"
  },{
    "type": "number"
  }]
}
```

In JsonSchema it is possible to use every schema inside the `allOf`, `anyOf` and
`oneOf` type. Through this it is possible to create inherent invalid schemas.

### Reasoning

In TypeJsonSchema every schema inside a `*Of` keyword must be either an object or
a reference pointing to an object. This has the great advantage that a processor
can use `allOf` to represent inheritance. Also a processor can securely merge
all `allOf` schemas into a single schema.

