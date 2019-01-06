
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
  * [Common](#common)
  * [Object](#object)
    * [Struct](#struct)
    * [Map](#map)
  * [Array](#array)
  * [Scalar](#scalar)
    * [Boolean](#boolean)
    * [Number](#number)
    * [String](#string)
* [Combination](#combination)
* [Reference](#reference)

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
