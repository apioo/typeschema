# TypeSchema

## About

TypeSchema is a JSON specification to describe data models.

A TypeSchema specification can be easily transformed into code for almost any programming language.
This helps to reuse core data models in different environments.
More information at: [https://typeschema.org](https://typeschema.org)

The TypeSchema meta specification which describes the specification itself is located at [specification/typeschema.json](./specification/typeschema.json).
We automatically push the specification to the [TypeHub platform](https://app.typehub.cloud/d/typehub/typeschema) where
you can see also a rendered version of the specification and download the auto generated models.

## Features

* An elegant specification optimized for code-generation
* A portable format to share data models across different programming languages
* Generate clean and simple to use DTOs
* Handle advanced concepts like inheritance, polymorphism and generics
* Use reflection to easily turn any class into a TypeSchema specification
* Easily implement your own code generator

## Generator

We provide a hosted version of the code generator at our [website](https://typeschema.org/generator).
To transform a TypeSchema specification into code you can use our [generator](https://github.com/apioo/typeschema-generator)
[docker image](https://hub.docker.com/r/apiootech/typeschema-generator). Simply run `docker-compose up` which reads the `typeschema.json`
specification from the `output/` folder and writes the generated code back into this folder.

```
services:
  generator:
    image: apiootech/typeschema-generator:0.6
    environment:
      # possible formats: csharp, go, java, php, python, rust, typescript
      FORMAT: "java"
      NAMESPACE: "org.acme"
      SOURCE: "typeschema.json"
    volumes:
      - ./output:/usr/src/typeschema/output
```

For more advanced integration options please take a look at the [SDKgen](https://sdkgen.app/) project
which offers various integration options like a CLI, GitHub action or REST API.

## Usage

Take a look at our [integration](https://typeschema.org/integration) page to see examples
how you can use the generated models in your code. The generator uses mostly standard or
well-known libraries therefor most developers should be familiar with this process.

## Models

TypeSchema provides auto-generated models which describe the specification itself. These models
can be used if you want to work with a TypeSchema specification.

| Language   | GitHub                                                         | Package                                                             |
|------------|----------------------------------------------------------------|---------------------------------------------------------------------|
| C#         | [GitHub](https://github.com/apioo/typeschema-model-csharp)     | [Nuget](https://www.nuget.org/packages/TypeSchema.Model/)           |
| Go         | [GitHub](https://github.com/apioo/typeschema-model-go)         |                                                                     |
| Java       | [GitHub](https://github.com/apioo/typeschema-model-java)       | [Maven](https://central.sonatype.com/artifact/org.typeschema/model) |
| JavaScript | [GitHub](https://github.com/apioo/typeschema-model-javascript) | [NPM](https://www.npmjs.com/package/typeschema-model)               |
| PHP        | [GitHub](https://github.com/apioo/typeschema-model-php)        | [Packagist](https://packagist.org/packages/typeschema/model)        |
| Python     | [GitHub](https://github.com/apioo/typeschema-model-python)     | [PyPI](https://pypi.org/project/typeschema-model/)                  |

## Reflection

The reflection libraries help to automatically generate a TypeSchema specification based on a class.
These libraries use the reflection mechanism of each language to inspect the class and create the fitting specification.

| Language | GitHub                                                         | Package                                                             |
|----------|----------------------------------------------------------------|---------------------------------------------------------------------|
| Java     | [GitHub](https://github.com/apioo/typeschema-reflection-java)       | [Maven](https://central.sonatype.com/artifact/org.typeschema/reflection) |
| PHP      | [GitHub](https://github.com/apioo/typeschema-reflection-php)        | [Packagist](https://packagist.org/packages/typeschema/reflection)        |
