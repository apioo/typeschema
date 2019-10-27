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

Our specification is directly generated from our TypeSchema meta schema which
describes the structure:

[TypeSchema Specification (draft)](https://chriskapp.github.io/typeschema/schema/schema.htm)
