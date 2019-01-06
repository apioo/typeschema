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

# Specification

Current [TypeJsonSchema Specification (draft)](spec/draft.md)

# Meta-Schema

We have developed a clean meta schema which you can use to check whether your
JSON schema is already a TypeJsonSchema. Please take a look at the [schema](schema/schema.json).

# Migration

The [Migration document](spec/migration.md) contains tips to convert
your JsonSchema to a TypeJsonSchema. 


