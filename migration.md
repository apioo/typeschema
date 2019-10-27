
# Migration

The following list covers all major restrictions to JsonSchema. This should help
to migrate your JsonSchema to TypeSchema:

## No-Type

### Invalid

```json
{
}
```

In JsonSchema it is possible to define no keyword which means every value is
valid.

### Reasoning

In TypeSchema every schema must have at least a `type` keyword. This is
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
there can be only one type. Therefore In TypeSchema the type must be a
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
of that TypeSchema has the `nullable` keyword which can be `true` or `false`
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

Since in TypeSchema you can define only one type, you can also use only the
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

In TypeSchema you need to decide between a struct or map. A struct contains
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

In TypeSchema every `object` type must have a `title` keyword. This is
required since processors need an identifier when generating code or other
formats. This helps processors to avoid generating the same type multiple times
and allows the usage of a fitting name. Relying on the "key" of the property is
not possible since different keys can point to the same schema.

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

In TypeSchema every schema inside a `*Of` keyword must be either an object or
a reference pointing to an object. This has the great advantage that a processor
can use `allOf` to represent inheritance. Also a processor can securely merge
all `allOf` schemas into a single schema.

## Anyof-Type

### Invalid

```json
{
  "anyOf": [{
    "type": "string"
  },{
    "type": "number"
  }]
}
```

In JsonSchema it is possible to use the `anyOf` keyword. In TypeSchema this keyword
does not exist. You can use either `oneOf` or `allOf`.

### Reasoning

The `anyOf` keyword is not practical for code generation. The `oneOf` type can be mapped
to a union type and the `allOf` type can be mapped to an intersection type but the
`anyOf` keyword has no fitting mapping.


## additionalItems

Do we need this keyword?

