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

In the JSON Schema core specification all keywords are optional and are applied
in context with the actual data. The idea of this specification is to build
schemas which have a distinct meaning independent of the actual data and which
can be used to generate different representations i.e. model classes of a
programming language. Because of this we must restrict existing keywords and
must make specific keywords mandatory depending on the context.

In this specification every schema is exactly assigned to a specific type of
schema: `Definition`, `Combination` or `Reference`. The distinction is made
based on the used keywords.

## Definition

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

## Combination

A combination schema combines multiple schemas in a specific way. 
It must follow the rules:

* Every schema MUST have one of the following keywords: `allOf` or `oneOf`.
* The value must be an array which can contain only definition or reference
  schemas. These schemas MUST be of type `object`.

## Reference

A reference schema makes a reference to another schema. It must follow the
rules:

* Every schema MUST have the keyword `$ref`.
* A reference schema MUST follow the same rules as a definition schema. That
  means i.e. if a reference is used inside the `allOf` keyword it MUST only
  reference object types.

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

Note: Since the JsonSchema evolves and potentially creates new keywords a
TypeJsonSchema processor should in general ignore all not known keywords.

## Keywords

* This specification restricts the usage of the validation keywords. Which
  keywords are allowed depends on the schema type.
* The following chapter lists all available keywords and describes the concrete
  behaviour.
* If not otherwise noted the behaviour of a keyword is identical to the JSON
  Schema validation specification.

### Definition keywords

The following keywords can be used to describe a definition schema.

### Common keywords


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
required so that a parser knows at least which type is expected.

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
`additionalProperties` keyword. For the `additionalProperties` every value must
follow the same schema. We think that the `patternProperties` keyword promotes
bad data design and we have not found a case where this is required. Also code
generators can not usefully understand those properties.

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
error-prone since different keys point to the same schema.
