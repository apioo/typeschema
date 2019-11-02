
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

In TypeSchema every schema must be assigned to a specific type depending on the
used keywords so that a parser knows at least which type is expected. Depending
on the type there are specific keywords possible.

## Array-Type

### Invalid

```json
{
  "type": ["string", "number"],
  "minLength": 12
}
```

In JsonSchema it is possible to allow multiple types at the `type` keyword.

### Reasoning

In TypeSchema `type` must be a `string` since based on this schema it is
impossible to generate a strongly typed class. To allow different types you
need to explicit use an union type (`oneOf` keyword)

## Array-Array-Item

### Invalid

```json
{
  "type": "array",
  "items": {
    "type": "array"
  }
}
```

In JsonSchema it is possible to use every schema as array item.

### Reasoning

In TypeSchema it is not possible to use an array as array value. This is done
because this constructs complicates code generators and it is also bad data
design. 

## Null-Type

### Invalid

```json
{
  "type": "null"
}
```

In JsonSchema it is possible to define the `null` type.

### Reasoning

We think that `null` is not a data type but rather an attribute of a type.
Because of that TypeSchema has the `nullable` keyword which can be `true` or
`false` for every type.

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

In TypeSchema the root `object` must have a `title` keyword. This is required
since processors need an identifier, inside the `definitions` the identifier is
based on the definitions key.

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

In JsonSchema it is possible to use the `anyOf` keyword. In TypeSchema this
keyword does not exist. You can use either `oneOf` or `allOf`.

### Reasoning

The `anyOf` keyword is not practical for code generation. The `oneOf` type can
be mapped to a union type and the `allOf` type can be mapped to an intersection
type.
