/**
 * Common properties which can be used at any type
 */
export interface CommonType {
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

/**
 * Properties for a scalar type
 */
export interface ScalarType extends CommonType {
    format?: string
    enum?: Array<string | number>
    default?: string | number | boolean
}

/**
 * Properties of a struct
 */
export type Properties = Record<string, BooleanType | NumberType | StringType | ArrayType | UnionType | IntersectionType | ReferenceType | GenericType>;

/**
 * A struct contains a fix set of defined properties
 */
export interface StructType extends CommonType {
    final?: boolean
    extends?: string
    type: string
    properties: Properties
    required?: Array<string>
}

/**
 * A map contains variable key value entries of a specific type
 */
export interface MapType extends CommonType {
    type: string
    additionalProperties: BooleanType | NumberType | StringType | ArrayType | UnionType | IntersectionType | ReferenceType | GenericType
    maxProperties?: number
    minProperties?: number
}

/**
 * An array contains an ordered list of a specific type
 */
export interface ArrayType extends CommonType {
    type: string
    items: BooleanType | NumberType | StringType | ReferenceType | GenericType
    maxItems?: number
    minItems?: number
}

/**
 * Represents a boolean value
 */
export interface BooleanType extends ScalarType {
    type: string
}

/**
 * Represents a number value (contains also integer)
 */
export interface NumberType extends ScalarType {
    type: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

/**
 * Represents a string value
 */
export interface StringType extends ScalarType {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

/**
 * An intersection type combines multiple types
 */
export interface IntersectionType {
    description?: string
    allOf: Array<ReferenceType>
}

/**
 * An object to hold mappings between payload values and schema names or references
 */
export type DiscriminatorMapping = Record<string, string>;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
export interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

/**
 * An union type can contain one of the provided schemas
 */
export interface UnionType {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<NumberType | StringType | BooleanType | ReferenceType>
}

export type TemplateProperties = Record<string, string>;

/**
 * Represents a reference to another type
 */
export interface ReferenceType {
    ref: string
    template?: TemplateProperties
}

/**
 * Represents a generic type
 */
export interface GenericType {
    generic: string
}

/**
 * Type definitions which can be reused
 */
export type Definitions = Record<string, StructType | MapType | ReferenceType>;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
export type Import = Record<string, string>;

/**
 * Reference a root type at the definitions
 */
export interface Root {
    import?: Import
    definitions: Definitions
    ref?: string
}
