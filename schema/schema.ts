/**
 * TypeSchema meta schema which describes a TypeSchema
 */
interface TypeSchema {
    $import?: Import
    title: string
    description?: string
    type: string
    definitions?: Definitions
    properties: Properties
    required?: Array<string>
}

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
interface Import {
    [index: string]: string
}

/**
 * Schema definitions which can be reused
 */
interface Definitions {
    [index: string]: ((CommonProperties & ContainerProperties & StructProperties) | (CommonProperties & ContainerProperties & MapProperties)) | (CommonProperties & ArrayProperties) | (CommonProperties & ScalarProperties & BooleanProperties) | (CommonProperties & ScalarProperties & NumberProperties) | (CommonProperties & ScalarProperties & StringProperties) | (AllOfProperties | OneOfProperties)
}

/**
 * Common properties which can be used at any schema
 */
interface CommonProperties {
    title?: string
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

/**
 * Properties specific for a container
 */
interface ContainerProperties {
    type: string
}

/**
 * Struct specific properties
 */
interface StructProperties {
    properties: Properties
    required?: Array<string>
}

/**
 * Map specific properties
 */
interface MapProperties {
    additionalProperties: (CommonProperties & ScalarProperties & BooleanProperties) | (CommonProperties & ScalarProperties & NumberProperties) | (CommonProperties & ScalarProperties & StringProperties) | (CommonProperties & ArrayProperties) | (AllOfProperties | OneOfProperties) | ReferenceType | GenericType
    maxProperties?: number
    minProperties?: number
}

/**
 * Array properties
 */
interface ArrayProperties {
    type: string
    items: (CommonProperties & ScalarProperties & BooleanProperties) | (CommonProperties & ScalarProperties & NumberProperties) | (CommonProperties & ScalarProperties & StringProperties) | ReferenceType | GenericType
    maxItems?: number
    minItems?: number
    uniqueItems?: boolean
}

interface ScalarProperties {
    format?: string
    enum?: Array<string> | Array<number>
    default?: string | number | boolean
}

/**
 * Boolean properties
 */
interface BooleanProperties {
    type: string
}

/**
 * Number properties
 */
interface NumberProperties {
    type: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

/**
 * String properties
 */
interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

/**
 * An intersection type combines multiple schemas into one
 */
interface AllOfProperties {
    description?: string
    allOf: Array<(CommonProperties & ScalarProperties & NumberProperties) | (CommonProperties & ScalarProperties & StringProperties) | (CommonProperties & ScalarProperties & BooleanProperties) | ReferenceType>
}

/**
 * An union type can contain one of the provided schemas
 */
interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<(CommonProperties & ScalarProperties & NumberProperties) | (CommonProperties & ScalarProperties & StringProperties) | (CommonProperties & ScalarProperties & BooleanProperties) | ReferenceType>
}

/**
 * Properties of a schema
 */
interface Properties {
    [index: string]: (CommonProperties & ScalarProperties & BooleanProperties) | (CommonProperties & ScalarProperties & NumberProperties) | (CommonProperties & ScalarProperties & StringProperties) | (CommonProperties & ArrayProperties) | (AllOfProperties | OneOfProperties) | ReferenceType | GenericType
}

/**
 * Represents a reference to another schema
 */
interface ReferenceType {
    $ref: string
    $template?: TemplateProperties
}

/**
 * Represents a generic type
 */
interface GenericType {
    $generic: string
}

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

interface TemplateProperties {
    [index: string]: ReferenceType
}

/**
 * An object to hold mappings between payload values and schema names or references
 */
interface DiscriminatorMapping {
    [index: string]: string
}
