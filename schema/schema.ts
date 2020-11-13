/**
 * Common properties which can be used at any schema
 */
export interface CommonProperties {
    title?: string
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

export interface ScalarProperties {
    format?: string
    enum?: EnumValue
    default?: ScalarValue
}

type PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

type Properties = Record<string, PropertyValue>;

/**
 * Properties specific for a container
 */
export interface ContainerProperties {
    type: string
}

/**
 * Struct specific properties
 */
export interface StructProperties {
    final?: boolean
    properties: Properties
    required?: StringArray
}

type StructType = CommonProperties & ContainerProperties & StructProperties;

/**
 * Map specific properties
 */
export interface MapProperties {
    additionalProperties: PropertyValue
    maxProperties?: number
    minProperties?: number
}

type MapType = CommonProperties & ContainerProperties & MapProperties;

type ObjectType = StructType | MapType;

type ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

/**
 * Array properties
 */
export interface ArrayProperties {
    type: string
    items: ArrayValue
    maxItems?: number
    minItems?: number
    uniqueItems?: boolean
}

type ArrayType = CommonProperties & ArrayProperties;

/**
 * Boolean properties
 */
export interface BooleanProperties {
    type: string
}

type BooleanType = CommonProperties & ScalarProperties & BooleanProperties;

/**
 * Number properties
 */
export interface NumberProperties {
    type: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

type NumberType = CommonProperties & ScalarProperties & NumberProperties;

/**
 * String properties
 */
export interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

type StringType = CommonProperties & ScalarProperties & StringProperties;

type AllOfValue = ReferenceType;

/**
 * An intersection type combines multiple schemas into one
 */
export interface AllOfProperties {
    description?: string
    allOf: Array<AllOfValue>
}

type DiscriminatorMapping = Record<string, string>;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
export interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

type OneOfValue = NumberType | StringType | BooleanType | ReferenceType;

/**
 * An union type can contain one of the provided schemas
 */
export interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<OneOfValue>
}

type CombinationType = AllOfProperties | OneOfProperties;

type TemplateProperties = Record<string, string>;

/**
 * Represents a reference to another schema
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

type DefinitionValue = ObjectType | ArrayType | CombinationType;

type Definitions = Record<string, DefinitionValue>;

type Import = Record<string, string>;

type EnumValue = StringArray | NumberArray;

type ScalarValue = string | number | boolean;

type StringArray = Array<string>;

type NumberArray = Array<number>;

/**
 * Reference a root schema at the definitions
 */
export interface Root {
    import?: Import
    definitions: Definitions
    ref: string
}
